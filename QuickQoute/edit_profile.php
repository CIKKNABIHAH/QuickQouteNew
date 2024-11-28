<?php
session_start();
include 'db.php'; // Make sure your database connection file is correctly referenced

// Check if the user is logged in and the form was submitted
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page if not logged in
    echo "<script>alert('Please log in to access this page.'); window.location.href = 'login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract and sanitize user inputs
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $new_password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

    // Check if new password fields are filled and match
    if (!empty($new_password) && $new_password == $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
        echo "<script>alert('Passwords do not match or are empty.'); window.location.href = 'edit_profile.php';</script>";
        exit;
    }

    // Prepare the update SQL statement
    $sql = "UPDATE customers SET customer_name=?, username=?, email=?, phone=?, password=? WHERE customer_id=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssi", $customer_name, $username, $email, $phone, $hashed_password, $_SESSION['user_id']);
        $result = $stmt->execute();

        // Check if the update was successful
        if ($result) {
            echo "<script>alert('Profile updated successfully.'); window.location.href = 'customerprofile.php';</script>";
        } else {
            echo "<script>alert('Failed to update profile. Error: ".$stmt->error."'); window.location.href = 'edit_profile.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error: ".$conn->error."'); window.location.href = 'edit_profile.php';</script>";
    }
    $conn->close();
} else {
    // Not a POST request
    echo "<script>window.location.href = 'edit_profile.php';</script>";
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickQuote - Edit Profile</title>
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
        .custom-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 2rem auto;
        }
        .custom-input {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        .custom-button {
            background-color: #4CAF50;
            color: white;
            padding: 0.75rem 1.5rem;
            text-align: center;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }
        .custom-button:hover {
            background-color: #45a049;
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
        <div class="custom-form fade-in">
            <h2 class="text-3xl font-bold mb-6 text-center">Edit Profile</h2>
            <form action="edit_profile.php" method="POST">
            <div class="mb-4">
                    <input type="text" id="customer_name" name="customer_name" placeholder="Name" required class="custom-input" >
                <div class="mb-4">
                    <input type="text" id="username" name="username" placeholder="Username" required class="custom-input">
                </div>
                <div class="mb-4">
                    <input type="email" id="email" name="email" placeholder="Email" required class="custom-input">
                </div>
                <div class="mb-4">
                    <input type="text" id="phone" name="phone" placeholder="Phone" class="custom-input">
                </div>
                <div class="mb-4">
                    <input type="password" id="password" name="password" placeholder="Password" required class="custom-input">
                </div>
                <div class="mb-4">
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required class="custom-input">
                </div>
                <div class="flex items-center justify-center">
                    <button type="submit" class="custom-button">Save edit</button>
                </div>
            </form>
        </div>
    </main>
    <footer class="bg-rose-300 text-gray-800 py-6 mt-auto">
        <div class="container mx-auto text-center">
            <p>© 2023 QuickQuote. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>