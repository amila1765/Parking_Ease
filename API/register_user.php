<?php
header("Content-Type: application/json");
include '../db/db_connection.php';

// Read incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Debugging: Log the received data
error_log(print_r($data, true));

// Validate input data
if (
    !isset($data['first_name']) || !isset($data['last_name']) ||
    !isset($data['birthday']) || !isset($data['gender']) ||
    !isset($data['contact_number']) || !isset($data['email']) ||
    !isset($data['password']) || !isset($data['vehicles'])
) {
    echo json_encode(["status" => "error", "message" => "Invalid input data."]);
    exit;
}

// Assign data
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$birthday = $data['birthday'];
$gender = $data['gender'];
$contact_number = $data['contact_number'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash password
$vehicles = $data['vehicles'];

try {
    // Start transaction
    $conn->begin_transaction();

    // Insert user into 'users' table
    $sql_user = "INSERT INTO users (first_name, last_name, birthday, gender, contact_number, email, password) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("sssssss", $first_name, $last_name, $birthday, $gender, $contact_number, $email, $password);
    $stmt_user->execute();
    $user_id = $stmt_user->insert_id; // Get the inserted user ID

    // Insert each vehicle into 'vehicles' table
    $sql_vehicle = "INSERT INTO vehicles (user_id, vehicle_type, vehicle_number) VALUES (?, ?, ?)";
    $stmt_vehicle = $conn->prepare($sql_vehicle);

    // Debugging: Log the vehicles array
    error_log(print_r($vehicles, true));

    foreach ($vehicles as $vehicle) {
        $vehicle_type = $vehicle['vehicle_type'];
        $vehicle_number = $vehicle['vehicle_number'];

        $stmt_vehicle->bind_param("iss", $user_id, $vehicle_type, $vehicle_number);
        $stmt_vehicle->execute();
    }

    // Commit transaction
    $conn->commit();

    // Success response
    echo json_encode(["status" => "success", "message" => "Account created successfully."]);
} catch (Exception $e) {
    // Rollback transaction in case of error
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Failed to create account. Error: " . $e->getMessage()]);
}

// Close database connection
$conn->close();
?>
