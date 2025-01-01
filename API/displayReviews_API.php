<?php
//Include database connection
include_once '../db/db_connection.php';

//Fetch reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC"; //Make sure 'created_at' exists in your database
$result = $conn->query($sql);

