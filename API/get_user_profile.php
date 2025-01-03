<?php
session_start();
require_once '../db/db_connection.php';

// Debugging: Check database connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Check session email
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'User is not logged in']);
    exit();
}

$email = $_SESSION['email'];

// Query to fetch user details
$userQuery = "SELECT user_id, first_name, last_name, birthday, gender, contact_number, email FROM users WHERE email = ?";
$stmt = $conn->prepare($userQuery);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'User query preparation failed']);
    exit();
}
$stmt->bind_param("s", $email);
$stmt->execute();
$userResult = $stmt->get_result();

// If user data found
if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $user_id = $userData['user_id'];

    // Fetch vehicles
    $vehicleQuery = "SELECT vehicle_id, vehicle_type, vehicle_number FROM vehicles WHERE user_id = ?";
    $stmt = $conn->prepare($vehicleQuery);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Vehicle query preparation failed']);
        exit();
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $vehicleResult = $stmt->get_result();

    $vehicles = [];
    while ($vehicle = $vehicleResult->fetch_assoc()) {
        $vehicles[] = $vehicle;
    }

    // Respond with user and vehicle data
    echo json_encode([
        'status' => 'success',
        'user' => $userData,
        'vehicles' => $vehicles
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}
?>
