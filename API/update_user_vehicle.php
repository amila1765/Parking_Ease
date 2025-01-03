<?php
header('Content-Type: application/json');
require_once '../db/db_connection.php';

$response = ["status" => "error", "message" => "Something went wrong."];

try {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (!isset($data['user_id']) || empty($data['user_id'])) {
        throw new Exception("User ID is required.");
    }

    if (!isset($data['first_name'], $data['last_name'], $data['birthday'], 
            $data['gender'], $data['contact_number'], $data['vehicles'])) {
        throw new Exception("Invalid input data.");
    }

    $user_id = $data['user_id'];
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $birthday = $data['birthday'];
    $gender = $data['gender'];
    $contact_number = $data['contact_number'];
    //$email = $data['email'];
    $vehicles = $data['vehicles'];

    // Begin transaction
    $conn->begin_transaction();

    // Update user details
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, birthday = ?, gender = ?, contact_number = ? WHERE user_id = ?");
    $stmt->bind_param("sssssi", $first_name, $last_name, $birthday, $gender, $contact_number, $user_id);
    $stmt->execute();

    // Process vehicles
    foreach ($vehicles as $vehicle) {
        if (!isset($vehicle['vehicle_type'], $vehicle['vehicle_number'])) {
            throw new Exception("Invalid vehicle data.");
        }

        $vehicle_id = isset($vehicle['vehicle_id']) ? $vehicle['vehicle_id'] : null;
        $vehicle_type = $vehicle['vehicle_type'];
        $vehicle_number = $vehicle['vehicle_number'];

        if ($vehicle_id) {
            // Update existing vehicle
            $stmt = $conn->prepare("UPDATE vehicles SET vehicle_type = ?, vehicle_number = ? WHERE vehicle_id = ? AND user_id = ?");
            $stmt->bind_param("ssii", $vehicle_type, $vehicle_number, $vehicle_id, $user_id);
        } else {
            // Insert new vehicle
            $stmt = $conn->prepare("INSERT INTO vehicles (user_id, vehicle_type, vehicle_number) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $vehicle_type, $vehicle_number);
        }

        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();
    $response = ["status" => "success", "message" => "Profile updated successfully."];

} catch (Exception $e) {
    $conn->rollback();
    $response = ["status" => "error", "message" => $e->getMessage()];
}

$conn->close();
echo json_encode($response);
