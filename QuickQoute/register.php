<?php
session_start();
include 'db.php';  // Make sure this is the correct path to your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Remove the check for existing email or username

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO customers (customer_name, username, email, phone, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssss", $customer_name, $username, $email, $phone, $password_hashed);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful. Please login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.'); window.location='register.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error. Please try again later.'); window.location='register.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickQuote - Register</title>
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
    <main class="container mx-auto py-10">
        <div class="custom-form fade-in">
            <h2 class="text-3xl font-bold mb-6 text-center">Register for QuickQuote</h2>
            <form action="register.php" method="POST">
                <div class="mb-4">
                    <input type="text" id="customer_name" name="customer_name" placeholder="Name" required class="custom-input">
                </div>
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
                    <button type="submit" class="custom-button">Register</button>
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
