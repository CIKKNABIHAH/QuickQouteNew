<?php
include 'db.php';
session_start();

// Check if order_id is provided in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details
    $stmt = $conn->prepare("
        SELECT o.order_id, o.customer_id, c.customer_name, c.email AS customer_email, c.phone AS customer_phone, 
               s.name AS service_name, p.package_name, o.ceremony_date, o.ceremony_venue
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN packages p ON o.package_id = p.package_id
        JOIN services s ON p.service_id = s.service_id
        WHERE o.order_id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $orderData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$orderData) {
        echo "<script>alert('Order not found.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Order ID not provided.'); window.history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Quotation - QuickQuote Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex">
        <div class="w-64 bg-gray-800 text-white h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-bold">QuickQuote Admin</h1>
            </div>
            <!-- Sidebar links -->
        </div>
        
        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Upload Quotation</h2>
            </header>

            <!-- Content -->
            <main class="p-6">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-2xl font-bold mb-4">New Quotation</h3>
                    <form action="submit_quote.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($orderData['order_id']); ?>">
                        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($orderData['customer_id']); ?>">

                        <div class="mb-4">
                            <label for="customer" class="block text-gray-700 font-bold mb-2">Customer Name</label>
                            <input type="text" id="customer" name="customer" value="<?php echo htmlspecialchars($orderData['customer_name']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                        </div>

                        <!-- Other form fields as before -->

                        <div class="mb-4">
                            <label for="quotation_file" class="block text-gray-700 font-bold mb-2">Upload Quotation (PDF)</label>
                            <input type="file" id="quotation_file" name="quotation_file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Upload Quotation
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
