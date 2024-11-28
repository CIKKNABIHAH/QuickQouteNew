<?php
session_start();
include 'db.php';

// Function to fetch all customers
function getCustomers($conn) {
    $stmt = $conn->prepare("SELECT * FROM customers");
    $stmt->execute();
    $result = $stmt->get_result();
    $customers = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $customers;
}

// Function to delete a customer
if (isset($_GET['delete_id'])) {
    $customer_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_customers.php?message=deleted");
    exit;
}

$customers = getCustomers($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - QuickQuote</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');

            if (message === 'added') {
                alert('Customer successfully added.');
            } else if (message === 'deleted') {
                alert('Customer successfully deleted.');
            }
        };
    </script>
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
            <li><a href="manage_customers.php" class="flex items-center active"><i class="fas fa-users mr-2"></i>Manage Customers</a></li>
            <li><a href="manageorders.php" class="flex items-center"><i class="fas fa-shopping-cart mr-2"></i>Manage Orders</a></li>
            <li><a href="admin_update_tracking.php" class="flex items-center"><i class="fas fa-shipping-fast mr-2"></i>Update Order Status</a></li>
            <li><a href="settings.php" class="flex items-center"><i class="fas fa-cog mr-2"></i>Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold">Manage Customers</h2>
            <div class="flex items-center">
                <span class="mr-4">Admin</span>
                <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded-full">Logout</a>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">
            <div class="container mx-auto py-10">
                <h2 class="text-3xl font-bold mb-6 text-center">Manage Customers</h2>
                <!-- Customers Table -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-2xl font-bold mb-4">Customer List</h3>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Phone</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b"><?php echo $customer['customer_id']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($customer['email']); ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($customer['phone']); ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="manage_customers.php?delete_id=<?php echo $customer['customer_id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-500 font-bold">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
