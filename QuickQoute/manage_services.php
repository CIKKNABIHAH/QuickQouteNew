<?php
session_start();
include 'db.php';

// Function to fetch all services
function getServices($conn) {
    $stmt = $conn->prepare("SELECT * FROM services");
    $stmt->execute();
    $result = $stmt->get_result();
    $services = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $services;
}

// Function to add a new service
if (isset($_POST['add_service'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO services (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_services.php?message=added");
    exit;
}

// Function to delete a service
if (isset($_GET['delete_id'])) {
    $service_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM services WHERE service_id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_services.php?message=deleted");
    exit;
}

$services = getServices($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - QuickQuote</title>
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
                alert('Service successfully added.');
            } else if (message === 'deleted') {
                alert('Service successfully deleted.');
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
            <li><a href="manage_services.php" class="flex items-center active"><i class="fas fa-cogs mr-2"></i>Manage Services</a></li>
            <li><a href="manage_packages.php" class="flex items-center"><i class="fas fa-box mr-2"></i>Manage Packages</a></li>
            <li><a href="manage_customers.php" class="flex items-center"><i class="fas fa-users mr-2"></i>Manage Customers</a></li>
            <li><a href="manageorders.php" class="flex items-center"><i class="fas fa-shopping-cart mr-2"></i>Manage Orders</a></li>
            <li><a href="admin_update_tracking.php" class="flex items-center"><i class="fas fa-shipping-fast mr-2"></i>Update Order Status</a></li>
            <li><a href="settings.php" class="flex items-center"><i class="fas fa-cog mr-2"></i>Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold">Manage Services</h2>
            <div class="flex items-center">
                <span class="mr-4">Admin</span>
                <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded-full">Logout</a>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">
            <div class="container mx-auto py-10">
                <h2 class="text-3xl font-bold mb-6 text-center">Manage Services</h2>

                <!-- Add Service Form -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-2xl font-bold mb-4">Add New Service</h3>
                    <form action="manage_services.php" method="POST">
                        <input type="hidden" name="add_service" value="1">
                        <div class="mb-4">
                            <label for="name" class="block font-semibold">Service Name</label>
                            <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block font-semibold">Description</label>
                            <textarea name="description" id="description" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded">Add Service</button>
                    </form>
                </div>

                <!-- Services Table -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-2xl font-bold mb-4">Service List</h3>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Description</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b"><?php echo $service['service_id']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($service['name']); ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($service['description']); ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="manage_services.php?delete_id=<?php echo $service['service_id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-500 font-bold">Delete</a>
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
