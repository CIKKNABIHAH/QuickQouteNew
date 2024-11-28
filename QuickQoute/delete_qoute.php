<?php
session_start();

include 'db.php'; // Include the database connection

// Check if order_id is provided in the URL
if (isset($_GET['quotation_id'])) {
    $quotation_id = $_GET['quotation_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // First, delete the related rows in the `order_services` table
        $stmt = $conn->prepare("DELETE FROM quotations WHERE quotation_id = ?");
        $stmt->bind_param("i", $quotation_id);
        $stmt->execute();
        $stmt->close();


        // Commit the transaction
        $conn->commit();

        // Redirect after successful deletion
        header("Location: admindashboard.php");
        exit;
    } catch (mysqli_sql_exception $exception) {
        // Rollback the transaction if there's an error
        $conn->rollback();

        // Display an error message
        echo "<script>alert('Failed to delete quotation due to a database error. Please try again.'); window.history.back();</script>";
    }
} else {
    // If no order_id is provided, show an error message
    echo "<script>alert('Quotation ID not provided.'); window.location.href = 'admindashboard.php';</script>";
}

// Close the database connection
$conn->close();
?>
