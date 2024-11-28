<?php
include 'db.php'; // Database connection
session_start();

// Check if quotation_id is provided in the URL
if (isset($_GET['quotation_id'])) {
    $quotation_id = $_GET['quotation_id'];

    // Fetch quotation details
    $stmt = $conn->prepare("SELECT * FROM quotations WHERE quotation_id = ?");
    $stmt->bind_param("i", $quotation_id);
    $stmt->execute();
    $quotationData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$quotationData) {
        echo "<script>alert('Quotation ID not found.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Quotation ID not provided.'); window.history.back();</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Page - QuickQuote Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Quotation Details</h2>
        <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($quotationData['customer_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($quotationData['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($quotationData['phone']); ?></p>
        <p><strong>Service:</strong> <?php echo htmlspecialchars($quotationData['service_name']); ?></p>
        <p><strong>Package:</strong> <?php echo htmlspecialchars($quotationData['package_name']); ?></p>
        <p><strong>Amount:</strong> RM<?php echo number_format($quotationData['amount'], 2); ?></p>

        <h3 class="text-xl font-bold mt-6 mb-4">Upload Quotation PDF</h3>
        <form action="upload_quotation_file.php" method="POST" enctype="multipart/form-data" class="mb-6">
            <input type="hidden" name="quotation_id" value="<?php echo $quotation_id; ?>">
            <div class="mb-4">
                <label for="file" class="block text-gray-700 font-bold mb-2">Choose PDF file:</label>
                <input type="file" name="file" id="file" accept=".pdf" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload PDF</button>
        </form>

        <h3 class="text-xl font-bold mb-4">Uploaded PDFs</h3>
        <?php
        // Fetch uploaded files for this quotation
        $stmt = $conn->prepare("SELECT file_path FROM quotation_files WHERE quotation_id = ?");
        $stmt->bind_param("i", $quotation_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($file = $result->fetch_assoc()) {
                echo '<p><a href="' . htmlspecialchars($file['file_path']) . '" target="_blank" class="text-blue-500 underline">View PDF</a></p>';
            }
        } else {
            echo "<p>No PDF files uploaded for this quotation.</p>";
        }

        $stmt->close();
        ?>
    </div>
</body>
</html>
