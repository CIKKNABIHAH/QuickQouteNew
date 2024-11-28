<?php
session_start();

include 'db.php'; // Include the database connection

// Check if order_id is provided in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // First, delete the related rows in the `order_services` table
        $stmt = $conn->prepare("DELETE FROM order_services WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        // Then, delete the main record in the `orders` table
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        // Redirect after successful deletion
        header("Location: orderdetails.php");
        exit;
    } catch (mysqli_sql_exception $exception) {
        // Rollback the transaction if there's an error
        $conn->rollback();

        // Display an error message
        echo "<script>alert('Failed to delete order due to a database error. Please try again.'); window.history.back();</script>";
    }
} else {
    // If no order_id is provided, show an error message
    echo "<script>alert('Order ID not provided.'); window.location.href = 'orderdetails.php';</script>";
}

// Close the database connection
$conn->close();
?>
