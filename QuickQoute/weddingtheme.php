<?php
// Include your database connection
include 'db.php';
// Set the `service_id` for wedding themes
$wedding_theme_service_id = 5;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickQuote - Wedding Theme Services</title>
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
        .service-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);
        }
        .service-card h3 {
            color: #e91e63;
        }
        .service-card p {
            color: #4A5568;
        }
        .service-card a {
            color: #fff;
            background-color: #e91e63;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background 0.3s;
        }
        .service-card a:hover {
            background-color: #c2185b;
        }
        .icon {
            font-size: 2rem;
            color: #e91e63;
        }
    </style>
</head>
<body>
    <header class="bg-rose-200 text-gray-800 py-6">
        <div class="container mx-auto text-left">
            <h1 class="text-4xl font-bold" style="font-family: 'Playfair Display', serif;">QuickQuote</h1>
            <p class="text-lg mt-2">Simplify Your Wedding Planning</p>
        </div>
    </header>
    <nav class="bg-rose-300">
        <div class="container mx-auto flex justify-end">
            <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="dashboard.php">Home</a>
            <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="service.php">Services</a>
            <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="customerprofile.php">Profile</a>
            <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="index.php">Logout</a>
        </div>
    </nav>
    <main class="container mx-auto py-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Wedding Theme Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            // Query to fetch packages where `service_id` matches wedding theme's ID
            $query = "SELECT * FROM packages WHERE service_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $wedding_theme_service_id); // Bind `service_id` value
            $stmt->execute();
            $result = $stmt->get_result();

            // Loop through each package and display it
            while ($package = $result->fetch_assoc()) {
                echo '<div class="service-card">';
                if (!empty($package['image_url'])) {
                    echo '<img src="' . htmlspecialchars($package['image_url']) . '" alt="Image of ' . htmlspecialchars($package['package_name']) . '">';
                }
                echo '<div class="flex items-center mb-4">';
                echo '<h3 class="text-xl font-bold">' . htmlspecialchars($package['package_name']) . '</h3>';
                echo '</div>';
                echo '<p class="text-gray-700 mb-2">' . htmlspecialchars($package['description']) . '</p>';
                echo '<p class="text-gray-700 mb-4">Price: RM' . htmlspecialchars($package['price']) . '</p>';
                echo '<a class="text-blue-600 hover:underline" href="orderdetails.php?package_id=' . htmlspecialchars($package['package_id']) . '">Order Package</a>';
                echo '</div>';
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </main>
    <footer class="bg-rose-300 text-gray-800 py-6 mt-auto">
        <div class="container mx-auto text-center">
            <p>© 2023 QuickQuote. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
