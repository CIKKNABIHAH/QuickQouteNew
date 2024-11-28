<?php
include 'db.php';
session_start();

// Check if admin is logged in (add a session check if necessary)
if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Admin login required.'); window.location.href = 'adminlogin.php';</script>";
    exit;
}

// Handle form submission to update order status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // Insert new status update for the specified order
    $stmt = $conn->prepare("INSERT INTO order_status_updates (order_id, status) VALUES (?, ?)");
    $stmt->bind_param("is", $order_id, $new_status);
    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully.'); window.location.href = 'admin_update_tracking.php';</script>";
    } else {
        echo "<script>alert('Error updating order status.');</script>";
    }
    $stmt->close();
}

// Fetch all orders to populate the dropdown
$orders_result = $conn->query("SELECT order_id FROM orders ORDER BY order_id DESC");
$orders = $orders_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Tracking - QuickQuote Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f9fafb;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #4a5568;
        }
        .form-group select, .form-group button {
            width: 100%;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #d1d5db;
            color: #4a5568;
        }
        .form-group button {
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group button:hover {
            background-color: #2563eb;
        }
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #2d3748;
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
        }
        .content {
            margin-left: 250px; /* Adjust based on sidebar width */
            width: calc(100% - 250px);
            padding: 20px;
        }
        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #cbd5e0;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #4a5568;
        }
        .sidebar a.active {
            background-color: #4a5568;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
<div class="sidebar">
        <div class="p-4">
            <h1 class="text-2xl font-bold">QuickQuote Admin</h1>
        </div>
        <ul class="mt-6">
            <li><a href="admindashboard.php" class="flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
            <li><a href="manage_services.php" class="flex items-center"><i class="fas fa-cogs mr-2"></i>Manage Services</a></li>
            <li><a href="manage_packages.php" class="flex items-center"><i class="fas fa-box mr-2"></i>Manage Packages</a></li>
            <li><a href="manage_customers.php" class="flex items-center"><i class="fas fa-users mr-2"></i>Manage Customers</a></li>
            <li><a href="manageorders.php" class="flex items-center"><i class="fas fa-shopping-cart mr-2"></i>Manage Orders</a></li>
            <li><a href="admin_update_tracking.php" class="flex items-center active"><i class="fas fa-shipping-fast mr-2"></i>Update Order Status</a></li>
            <li><a href="settings.php" class="flex items-center"><i class="fas fa-cog mr-2"></i>Settings</a></li>
        </ul>
    </div>
    <div class="container mx-auto py-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Update Order Tracking Status</h2>
        <form action="admin_update_tracking.php" method="POST" class="form-container">
            <div class="form-group">
                <label for="order_id">Order ID</label>
                <select name="order_id" id="order_id" required>
                    <?php foreach ($orders as $order): ?>
                        <option value="<?php echo $order['order_id']; ?>"><?php echo $order['order_id']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="status">New Status</label>
                <select name="status" id="status" required>
                    <option value="Quotation Process">Quotation Process</option>
                    <option value="View Quotation">View Quotation</option>
                    <option value="Get Invoices">Get Invoices</option>
                    <option value="Order Prepare">Order Prepare</option>
                    <option value="Payment">Payment</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>
            <div class="form-group text-center">
                <button type="submit">Update Status</button>
            </div>
        </form>
        <div class="text-center mt-8">
            <a href="admindashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
