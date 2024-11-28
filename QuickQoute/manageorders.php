<?php
include 'db.php'; // Include your database connection
session_start();

// Function to fetch orders with customer, service, package, and details information
function getOrders() {
    global $conn;
    $sql = "
        SELECT o.order_id, c.customer_name, s.name AS service_name, p.package_name, 
               o.ceremony_date, o.ceremony_venue, o.details
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN packages p ON o.package_id = p.package_id
        JOIN services s ON p.service_id = s.service_id
        ORDER BY o.order_id DESC
    ";
    $result = $conn->query($sql);
    $orders = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    return $orders;
}

// Fetch orders and assign to $orders variable
$orders = getOrders();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - QuickQuote Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
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
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4">
            <h1 class="text-2xl font-bold">QuickQuote Admin</h1>
        </div>
        <ul class="mt-6">
            <li><a href="admindashboard.php" class="flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
            <li><a href="manage_services.php" class="flex items-center"><i class="fas fa-cogs mr-2"></i>Manage Services</a></li>
            <li><a href="manage_packages.php" class="flex items-center"><i class="fas fa-box mr-2"></i>Manage Packages</a></li>
            <li><a href="manage_customers.php" class="flex items-center"><i class="fas fa-users mr-2"></i>Manage Customers</a></li>
            <li><a href="manageorders.php" class="flex items-center active"><i class="fas fa-shopping-cart mr-2"></i>Manage Orders</a></li>
            <li><a href="admin_update_tracking.php" class="flex items-center"><i class="fas fa-shipping-fast mr-2"></i>Update Order Status</a></li>
            <li><a href="settings.php" class="flex items-center"><i class="fas fa-cog mr-2"></i>Settings</a></li>
        </ul>
    </div>
        <!-- Main Content -->
        <div class="content">
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Manage Orders</h2>
                <div class="flex items-center">
                    <span class="mr-4">Admin</span>
                    <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded-full">Logout</a>
                </div>
            </header>
            <!-- Content -->
            <main class="p-6">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-2xl font-bold mb-4">Orders List</h3>
                    <table class="min-w-full bg-white">
                        <thead class="table-header">
                            <tr>
                                <th class="py-2 px-4 border-b">Order ID</th>
                                <th class="py-2 px-4 border-b">Customer Name</th>
                                <th class="py-2 px-4 border-b">Service</th>
                                <th class="py-2 px-4 border-b">Package</th>
                                <th class="py-2 px-4 border-b">Date of Ceremony</th>
                                <th class="py-2 px-4 border-b">Venue</th>
                                <th class="py-2 px-4 border-b">Details</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr class="table-row">
                                        <td class="py-2 px-4 border-b"><?php echo $order['order_id']; ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['service_name']); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['package_name']); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['ceremony_date']); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['ceremony_venue']); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($order['details']); ?></td>
                                        <td class="py-2 px-4 border-b action-buttons">
                                        <form action="createquotation.php" method="GET">
                                          <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                          <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Request Quotation</button>
                                        </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="py-2 px-4 border-b text-center">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
        </div>
    </div>
</body>
</html>
