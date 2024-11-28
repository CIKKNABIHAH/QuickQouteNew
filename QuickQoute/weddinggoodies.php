<?php
// Include your database connection
include 'db.php';
// Set the `service_id` for catering. Adjust `service_id` as needed.
$wedding_goodies_service_id = 9; // Replace with the actual ID for catering in your `services` table.
?>

<html>
<head>
    <title>QuickQuote - Wedding Goodies Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('https://storage.googleapis.com/a1aa/image/wedding-background.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        .fade-in { animation: fadeIn 1s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .service-card { background: rgba(255, 255, 255, 0.9); padding: 1.5rem; border-radius: 1rem; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .service-card:hover { transform: translateY(-5px); box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2); }
        .service-card h3 { color: #e91e63; }
        .service-card p { color: #4A5568; }
        .service-card a { color: #3b82f6; }
        .service-card a:hover { text-decoration: underline; }
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
        <h2 class="text-3xl font-bold mb-6 text-center">Wedding Goodies Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            // Include your database connection
            include 'db.php';

            // Set the `service_id` for Wedding Goodies. Adjust `service_id` as needed.
            $wedding_goodies_service_id = 9; // Replace with the actual ID for Wedding Goodies in your `services` table.

            // Query to fetch packages where `service_id` matches Wedding Goodies' ID
            $query = "SELECT * FROM packages WHERE service_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $wedding_goodies_service_id); // Bind `service_id` value
            $stmt->execute();
            $result = $stmt->get_result();

            // Loop through each package and display it
            while ($package = $result->fetch_assoc()) {
                echo '<div class="service-card fade-in">';
                if (!empty($package['image_url'])) {
                    echo '<img src="' . htmlspecialchars($package['image_url']) . '" alt="Image of ' . htmlspecialchars($package['package_name']) . '">';
                }
                echo '<h3 class="text-xl font-bold mb-2">' . htmlspecialchars($package['package_name']) . '</h3>';
                echo '<p class="text-gray-700 mb-2">' . htmlspecialchars($package['description']) . '</p>';
                echo '<p class="text-gray-700 mb-2">Price: RM' . htmlspecialchars($package['price']) . '</p>';
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