<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Both fields are required.'); window.location.href = 'login.php';</script>";
    } else {
        $sql = "SELECT * FROM customers WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['customer_id'] = $user['customer_id']; // Changed to 'customer_id'
                $_SESSION['customer_name'] = $user['username'];
                echo "<script>alert('Login successful! Redirecting to dashboard...'); window.location.href = 'dashboard.php';</script>";
            } else {
                echo "<script>alert('Invalid email or password.'); window.location.href = 'login.php';</script>";
            }
        } else {
            echo "<script>alert('No user found with that email address.'); window.location.href = 'login.php';</script>";
        }
        $stmt->close();
    }
}
$conn->close();

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickQuote - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        .custom-label {
            color: #4A5568;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: left;
        }
        .custom-form {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        main {
            flex: 1;
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
    <main class="container mx-auto py-10 text-center">
        <h2 class="text-3xl font-bold mb-6">Login to QuickQuote</h2>
        <div class="bg-white shadow-2xl rounded-lg p-8 m-4 w-full md:w-3/4 lg:w-1/2 mx-auto custom-form">
        <form method="POST" action="login.php">
                <div class="mb-4 text-left">
                    <label class="custom-label" for="email">Email</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" placeholder="Email" type="email" required />
                </div>
                <div class="mb-6 text-left">
                    <label class="custom-label" for="password">Password</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" placeholder="Password" type="password" required />
                </div>
                <div class="mb-2 text-right">
                    <a class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800" href="#">Forgot Password?</a>
                </div>
                <div class="flex items-center justify-center">
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="login">Login</button>
                </div>
                <div class="mt-4 text-center">
                    <a class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800" href="register.php">First time user? Sign up here</a>
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
