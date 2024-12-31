<?php

header("Content-Type: application/json");
include '../db/db_connection.php';
session_start(); // Start session

// Get the data from the frontend (JSON)
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'];
$password = $data['password'];

// Prepare SQL query to check if the user exists and get the password
$query = "SELECT user_id, first_name, last_name, password FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user_id, $first_name, $last_name, $hashed_password);
$stmt->fetch();

// Check if user exists
if ($stmt->num_rows > 0) {
    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Store user details in session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $first_name . ' ' . $last_name;
        $_SESSION['email'] = $email;

        // Log login activity in the login_activity table
        $login_time = date('Y-m-d H:i:s');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $activity_query = "INSERT INTO login_activity (user_id, login_time, ip_address, user_agent, status) VALUES (?, ?, ?, ?, 'Success')";
        $activity_stmt = $conn->prepare($activity_query);
        $activity_stmt->bind_param('isss', $user_id, $login_time, $ip_address, $user_agent);
        $activity_stmt->execute();

        // Respond with success
        echo json_encode(['status' => 'success']);
    } else {
        // Incorrect password, log the failed attempt
        logFailedAttempt(null, $email, $conn);
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
} else {
    // User does not exist, log the failed attempt
    logFailedAttempt(null, $email, $conn);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
}

// Close the statements and connection
$stmt->close();
$conn->close();

// Function to log failed attempts
function logFailedAttempt($user_id, $email, $conn) {
    $login_time = date('Y-m-d H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    $activity_query = "INSERT INTO login_activity (user_id, login_time, ip_address, user_agent, status) VALUES (?, ?, ?, ?, 'Failed')";
    $activity_stmt = $conn->prepare($activity_query);
    $activity_stmt->bind_param('isss', $user_id, $login_time, $ip_address, $user_agent);
    $activity_stmt->execute();
    $activity_stmt->close();
}
?>
