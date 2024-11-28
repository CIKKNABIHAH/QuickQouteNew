<?php
session_start();
include 'db.php';  // Make sure this path is correctly pointing to your database connection script

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Please log in to view this page.'); window.location.href = 'login.php';</script>";
    exit;
}

$user_id = $_SESSION['customer_id']; // Retrieve user ID from session

// Fetch user details from database
$sql = "SELECT * FROM customers WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>alert('No user found.'); window.location.href = 'login.php';</script>";
    exit;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickQuote - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f7f7f7;
        }
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 2rem auto;
            text-align: center;
        }
        .profile-info {
            margin-bottom: 1rem;
        }
        .profile-info h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .profile-info p {
            font-size: 1rem;
            color: #4A5568;
        }
        .edit-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-rose-200 text-gray-800 py-6">
        <div class="container mx-auto text-left">
            <h1 class="text-4xl font-bold" style="font-family: 'Playfair Display', serif;">QuickQuote</h1>
            <p class="text-lg mt-2">Simplify Your Wedding Planning</p>
        </div>
    </header>
    <nav class="bg-rose-300">
   <div class="container mx-auto flex justify-end">
    <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="dashboard.php">
     Home
    </a>
    <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="service.php">
     Services
    </a>
    <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="customerprofile.php">
     Profile
    </a>
    <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="index.php">
     Logout
    </a>
   </div>
  </nav>
    <main class="container mx-auto py-10">
        <div class="profile-card fade-in">
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user['customer_name']); ?></h2>
                <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
                <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                <p>Phone: <?php echo htmlspecialchars($user['phone']); ?></p>
            </div>
            <button class="edit-button" onclick="location.href='edit_profile.php'">Edit Profile</button>
        </div>
    </main>
    <footer class="bg-rose-300 text-gray-800 py-6 mt-auto">
        <div class="container mx-auto text-center">
            <p>© 2023 QuickQuote. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
