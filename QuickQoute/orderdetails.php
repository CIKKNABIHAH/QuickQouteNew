<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Please login to request a quote.'); window.location.href = 'login.php';</script>";
    exit;
}

// Check if package_id is provided in the URL
if (isset($_GET['package_id']) && !empty($_GET['package_id'])) {
    $package_id = $_GET['package_id'];

    // Prepare the SQL query to get package details
    $query = "SELECT * FROM packages WHERE package_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();

    // Check if the package was found
    if (!$package) {
        echo "<script>alert('Invalid package selected.'); window.location.href = 'service.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No package selected.'); window.location.href = 'service.php';</script>";
    exit;
}

// Handle submission of order details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['customer_id'];
    $request_date = date("Y-m-d H:i:s");
    $ceremony_date = $_POST['ceremony_date'];
    $ceremony_venue = $_POST['ceremony_venue'];
    $details = $_POST['details'];

    // Insert order details into the database
    $insert_order = "INSERT INTO orders (customer_id, package_id, request_date, ceremony_date, ceremony_venue, details) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_order);
    $stmt->bind_param("iissss", $user_id, $package_id, $request_date, $ceremony_date, $ceremony_venue, $details);

    if ($stmt->execute()) {
        echo "<script>alert('Request sent successfully! The admin will prepare a quotation.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to send request. Please try again.');</script>";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - QuickQuote</title>
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
        .custom-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 2rem auto;
            text-align: center;
        }
        .custom-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .custom-card p {
            font-size: 1rem;
            color: #4A5568;
            margin-bottom: 1rem;
        }
        button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
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
        <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="dashboard.php">Home</a>
        <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="service.php">Services</a>
        <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="customerprofile.php">Profile</a>
        <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="index.php">Logout</a>
       </div>
    </nav>
    <main class="container mx-auto py-10">
        <div class="custom-card fade-in">
            <h2 class="text-3xl font-bold mb-6">Request Quotation</h2>
            <h3 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($package['package_name']); ?></h3>
            <p class="mb-4"><?php echo htmlspecialchars($package['description']); ?></p>
            <p class="mb-4">Price Estimate: RM<?php echo number_format($package['price'], 2); ?></p>
            
            <form action="orderdetails.php?package_id=<?php echo $package_id; ?>" method="POST">
                <div class="mb-4">
                    <label for="ceremony_date" class="block text-gray-700 text-sm font-bold mb-2">Ceremony Date:</label>
                    <input type="date" id="ceremony_date" name="ceremony_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="ceremony_venue" class="block text-gray-700 text-sm font-bold mb-2">Ceremony Venue Address:</label>
                    <input type="text" id="ceremony_venue" name="ceremony_venue" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="details" class="block text-gray-700 text-sm font-bold mb-2">Additional Details / Comments:</label>
                    <textarea id="details" name="details" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4" placeholder="Enter any additional comments about the package or special requests"></textarea>
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Request Quotation</button>
            </form>
            <p class="mt-4 text-gray-600">The quotation will be available within 3 working hours.</p>
        </div>
    </main>
    <footer class="bg-rose-300 text-gray-800 py-6 mt-auto">
        <div class="container mx-auto text-center">
            <p>© 2023 QuickQuote. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
