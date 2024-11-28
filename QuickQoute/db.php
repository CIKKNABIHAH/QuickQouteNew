<?php
$servername = "localhost"; // This should remain 'localhost' for local XAMPP
$username = "root";        // Default username for XAMPP is 'root'
$password = "";            // Default password is an empty string (leave as "")
$dbname = "quickquote";  // Ensure this matches the database name in phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);

// Test if the connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
   // echo "<script>alert('Database connected successfully');</script>";
}


?>
