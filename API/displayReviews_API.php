<?php
//Include database connection
include_once '../db/db_connection.php';

//Fetch reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC"; //Make sure 'created_at' exists in your database
$result = $conn->query($sql);

//Check if reviews exist
if ($result->num_rows > 0){
    // Store reviews in an array
    $reviews = [];
    while ($row = $result->fetch_assoc()){
        $reviews[] = $row;
    }

    //Return reviews as JSON
    echo json_encode($reviews);
}else {
    // No reviews found, return an empty array
    echo json_encode([]);
}

$conn->close(); //Close the database connection
?>


