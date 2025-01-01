<?php

header("Content-Type: application/json");
include '../db/db_connection.php';
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Update the logout time in the login_activity table
    $logout_time = date('Y-m-d H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Update the most recent login activity record for the user
    $update_query = "UPDATE login_activity SET logout_time = ? WHERE user_id = ? AND logout_time IS NULL ORDER BY login_time DESC LIMIT 1";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $logout_time, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Destroy the session
        session_destroy();
        echo json_encode(['status' => 'success', 'message' => 'Logout successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update logout time']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
}

$conn->close();
?>
