<?php
session_start();
include 'db.php';

// Check if admin is logged in (Assuming you set `admin_id` when logging in)
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];

// Fetch current admin details
$stmt = $conn->prepare("SELECT * FROM admin_users WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Update admin profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update the password only if it's provided
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admin_users SET username = ?, email = ?, password = ? WHERE admin_id = ?");
        $stmt->bind_param("sssi", $username, $email, $hashedPassword, $admin_id);
    } else {
        $stmt = $conn->prepare("UPDATE admin_users SET username = ?, email = ? WHERE admin_id = ?");
        $stmt->bind_param("ssi", $username, $email, $admin_id);
    }

    $stmt->execute();
    $stmt->close();

    // Refresh data to reflect changes
    header("Location: settings.php?message=updated");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - QuickQuote</title>
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
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');

            if (message === 'updated') {
                alert('Profile successfully updated.');
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
            <li><a href="manage_customers.php" class="flex items-center"><i class="fas fa-users mr-2"></i>Manage Customers</a></li>
            <li><a href="manageorders.php" class="flex items-center"><i class="fas fa-shopping-cart mr-2"></i>Manage Orders</a></li>
            <li><a href="admin_update_tracking.php" class="flex items-center"><i class="fas fa-shipping-fast mr-2"></i>Update Order Status</a></li>
            <li><a href="settings.php" class="flex items-center active"><i class="fas fa-cog mr-2"></i>Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold">Admin Settings</h2>
            <div class="flex items-center">
                <span class="mr-4"><?php echo htmlspecialchars($admin['username']); ?></span>
                <a href="logout.php" class="bg-blue-600 text-white px-4 py-2 rounded-full">Logout</a>
            </div>
        </header>

        <main class="p-6">
            <div class="container mx-auto py-10">
                <h2 class="text-3xl font-bold mb-6 text-center">Update Profile</h2>

                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <form action="settings.php" method="POST">
                        <div class="mb-4">
                            <label for="username" class="block font-semibold">Username</label>
                            <input type="text" name="username" id="username" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block font-semibold">Email</label>
                            <input type="email" name="email" id="email" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block font-semibold">New Password (Leave blank to keep current password)</label>
                            <input type="password" name="password" id="password" class="w-full p-2 border rounded">
                        </div>
                        <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded">Update Profile</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
