<?php
session_start();
include '../db/db_connection.php'; // Include database connection

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

$email = $_SESSION['email']; // Get logged-in user's email

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);
$password = $data['password'] ?? '';

// Validate input
if (empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Password is required.']);
    exit();
}

try {
    $conn->begin_transaction(); // Start transaction
    
    // Verify user password
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
        exit();
    }


    // Delete associated vehicles first
    $stmt = $conn->prepare("DELETE FROM vehicles WHERE user_id = (SELECT user_id FROM users WHERE email = ?)");
    $stmt->execute([$email]);

    // Delete reservations for the user
    $stmt = $conn->prepare("DELETE FROM reservations WHERE user_id = (SELECT user_id FROM users WHERE email = ?)");
    $stmt->execute([$email]);

    // Delete user profile
    $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $conn->commit(); // Commit transaction

    // Destroy session and logout
    session_destroy();

    echo json_encode(['status' => 'success', 'message' => 'Profile deleted successfully.']);
    exit();

} catch (Exception $e) {
    $conn->rollBack(); // Rollback transaction on error
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete profile.']);
    exit();
}
