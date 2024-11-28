<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $customer_id = $_POST['customer_id'];
    $uploadDir = 'uploads/quotations/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['quotation_file']) && $_FILES['quotation_file']['error'] == 0) {
        $fileTmpPath = $_FILES['quotation_file']['tmp_name'];
        $fileName = $_FILES['quotation_file']['name'];
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $filePath)) {
            $stmt = $conn->prepare("INSERT INTO quotations (order_id, customer_id, file_path) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $order_id, $customer_id, $filePath);

            if ($stmt->execute()) {
                echo "<script>alert('Quotation uploaded successfully!'); window.location.href = 'manageorders.php';</script>";
            } else {
                echo "<script>alert('Database insertion failed.'); window.history.back();</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('File upload failed.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid PDF file.'); window.history.back();</script>";
    }
}

$conn->close();
?>
