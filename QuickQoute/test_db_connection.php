<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include 'db.php';

// Test the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    
}

// Close the connection after testing
$conn->close();
?>
