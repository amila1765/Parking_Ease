<?php
header('Content-Type: application/json');

// Include database connection
require_once '../db/db_connection.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get input data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contactNumber = trim($_POST['contactNumber'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate inputs
    if (empty($name) || empty($email) || empty($contactNumber) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
        exit;
    }

    if (!preg_match('/^[0-9]{10,15}$/', $contactNumber)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid contact number.']);
        exit;
    }

    try {
        // Prepare SQL query to insert data
        $sql = "INSERT INTO contactsubmissions (Name, Email, ContactNumber, Message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $email, $contactNumber, $message);

        // Execute query
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close(); 
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
