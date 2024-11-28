<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Please log in to track your orders.'); window.location.href = 'login.php';</script>";
    exit;
}

// Retrieve the order_id from the URL
$order_id = $_GET['order_id'] ?? null;

// Validate order_id before querying the database
if (!$order_id) {
    echo "<script>alert('Order ID is missing.'); window.location.href = 'dashboard.php';</script>";
    exit;
}

// Fetch order status updates for the specific order_id
$stmt = $conn->prepare("SELECT status, updated_at FROM order_status_updates WHERE order_id = ? ORDER BY updated_at ASC");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$status_updates = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking - QuickQuote</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tracking-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
            margin-top: 20px;
        }
        .tracking-step {
            text-align: center;
            width: 20%;
        }
        .tracking-step .circle {
            width: 30px;
            height: 30px;
            background-color: #d1d5db;
            border-radius: 50%;
            margin: 0 auto;
        }
        .tracking-step.completed .circle {
            background-color: #3b82f6;
        }
        .tracking-line {
            flex-grow: 1;
            height: 2px;
            background-color: #d1d5db;
            position: relative;
            top: -15px;
        }
        .tracking-line.active {
            background-color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto py-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Order Tracking</h2>

        <?php if (!empty($status_updates)): ?>
            <div class="tracking-container">
                <?php
                // Define the exact status names as they appear in your database
                $statuses = ["Quotation Process", "View Quotation", "Get Invoices", "Order Prepare", "Payment", "Delivered"];
                
                // Loop through each expected status and check if it's completed
                foreach ($statuses as $index => $status):
                    $completed = false;
                    foreach ($status_updates as $update) {
                        if ($update['status'] == $status) {
                            $completed = true;
                            break;
                        }
                    }
                ?>
                <div class="tracking-step <?php echo $completed ? 'completed' : ''; ?>">
                    <div class="circle"></div>
                    <p><?php echo $status; ?></p>
                </div>
                <?php if ($index < count($statuses) - 1): ?>
                <div class="tracking-line <?php echo $completed ? 'active' : ''; ?>"></div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-red-500">No tracking updates available for this order.</p>
        <?php endif; ?>

        <div class="text-center mt-8">
            <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
