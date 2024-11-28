<?php
include 'db.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Customer ID not set. Please log in again.'); window.location.href = 'login.php';</script>";
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Check if `quotation_id` is provided in the URL
if (isset($_GET['quotation_id'])) {
    $quotation_id = $_GET['quotation_id'];

    // Fetch the file path of the selected quotation based on `quotation_id`
    $stmt = $conn->prepare("SELECT file_path FROM quotations WHERE quotation_id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $quotation_id, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $quotation = $result->fetch_assoc();
    $stmt->close();

    // Check if the file path is found
    $filePath = $quotation['file_path'] ?? null;
} else {
    echo "<script>alert('Quotation ID not provided.'); window.location.href = 'dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quotation - QuickQuote</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto py-10">
        <h2 class="text-3xl font-bold mb-6">Your Quotation</h2>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-2xl font-bold mb-4">Quotation ID: <?php echo htmlspecialchars($quotation_id); ?></h3>
            
            <?php if ($filePath && file_exists($filePath)): ?>
                <p class="text-lg mb-4">You can view your quotation below:</p>
                <iframe src="<?php echo htmlspecialchars($filePath); ?>" width="100%" height="600px"></iframe>
            <?php else: ?>
                <p class="text-lg text-red-600">Quotation not available.</p>
            <?php endif; ?>

            <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-6 inline-block">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
