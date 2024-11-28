<?php
include 'db.php'; // Make sure this is your database connection file

// Fetching data for the dashboard cards
$totalQuotes = getTotalQuotes();
$totalUsers = getTotalUsers();
$totalOrders = getTotalOrders();

// Function to fetch total number of quotes
function getTotalQuotes() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM quotations";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to fetch total number of users
function getTotalUsers() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM customers";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to fetch total number of orders
function getTotalOrders() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickQuote Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
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
            <li><a href="admindashboard.php" class="flex items-center active"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
            <li><a href="manage_services.php" class="flex items-center"><i class="fas fa-cogs mr-2"></i>Manage Services</a></li>
            <li><a href="manage_packages.php" class="flex items-center "><i class="fas fa-box mr-2"></i>Manage Packages</a></li>
            <li><a href="manage_customers.php" class="flex items-center"><i class="fas fa-users mr-2"></i>Manage Customers</a></li>
            <li><a href="manageorders.php" class="flex items-center"><i class="fas fa-shopping-cart mr-2"></i>Manage Orders</a></li>
            <li><a href="admin_update_tracking.php" class="flex items-center"><i class="fas fa-shipping-fast mr-2"></i>Update Order Status</a></li>
            <li><a href="settings.php" class="flex items-center"><i class="fas fa-cog mr-2"></i>Settings</a></li>
        </ul>
        </div>
        <!-- Main Content -->
    <div class="content">     
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Dashboard</h2>
                <div class="flex items-center">
                    <span class="mr-4">Admin</span>
                    <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded-full">Logout</a>
                </div>
            </header>
            <!-- Content -->
            <main class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white shadow-md rounded-lg p-4 text-center">
                        <i class="fas fa-quote-right text-blue-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-2">Total Quotes</h3>
                        <p class="text-gray-700 text-2xl"><?php echo $totalQuotes; ?></p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white shadow-md rounded-lg p-4 text-center">
                        <i class="fas fa-users text-blue-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-2">Total Users</h3>
                        <p class="text-gray-700 text-2xl"><?php echo $totalUsers; ?></p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white shadow-md rounded-lg p-4 text-center">
                        <i class="fas fa-shopping-cart text-blue-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-2">Total Orders</h3>
                        <p class="text-gray-700 text-2xl"><?php echo $totalOrders; ?></p>
                    </div>
                </div>  
            </main>
        </div>
    </di,v>

</body>
</html>
