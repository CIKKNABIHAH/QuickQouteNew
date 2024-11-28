<?php
include 'db.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Customer ID not set. Please log in again.'); window.location.href = 'login.php';</script>";
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Fetch all quotations for the customer
$stmt = $conn->prepare("SELECT quotation_id, file_path FROM quotations WHERE customer_id = ? ORDER BY quotation_id DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$quotations = $result->fetch_all(MYSQLI_ASSOC); // Fetch all quotations as an associative array
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quotations - QuickQuote</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto py-10">
        <h2 class="text-3xl font-bold mb-6">Your Quotations</h2>
        <div class="bg-white shadow-md rounded-lg p-6">
            <?php if (!empty($quotations)): ?>
                <p class="text-lg mb-4">Click on a quotation ID to view the file:</p>
                <ul class="mb-4">
                    <?php foreach ($quotations as $quotation): ?>
                        <li>
                            <a href="viewquotation.php?quotation_id=<?php echo $quotation['quotation_id']; ?>" class="text-blue-500 hover:underline">
                                Quotation ID: <?php echo htmlspecialchars($quotation['quotation_id']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-lg text-red-600">No quotations available.</p>
            <?php endif; ?>
            <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-6 inline-block">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
