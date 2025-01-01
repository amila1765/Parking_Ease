<?php
// Include the database connection
include_once '../db/db_connection.php';

//Check if form data has been posted
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Sanitize and validate the form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $review_text = mysqli_real_escape_string($conn, $_POST['review']);
    $rating = (int)$_POST['rating'];

    //Validate the rating (should be between 1 and 5)
    if ($rating < 1 || $rating > 5){
        echo json_encode(['status' => 'error', 'message' => 'Invalid rating value.']);
        exit;
    }

    //Prepare the SQL query to insert the review into the database
    $sql = "INSERT INTO reviews (Name, Email, review_text, rating)
            VALUES ('$name', '$email', $review_text', '$rating')";
    
    // Log the SQL query for debugging 
    error_log("SQL Query: " . $sql);

    

}