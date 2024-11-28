<?php
include 'db.php';
session_start();

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Please log in to access the dashboard.'); window.location.href = 'login.php';</script>";
    exit;
}

$customer_id = $_SESSION['customer_id'];


// Fetch the most recent order ID for this customer (update if necessary)
$query = "SELECT order_id FROM orders WHERE customer_id = ? ORDER BY order_id DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$order_id = $order['order_id'] ?? null;
$stmt->close();

$_SESSION['order_id'] = $order_id; // Store order ID in session
?>


<html>
 <head>
  <title>
   QuickQuote - Customer Dashboard
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet"/>
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
            color: #4A5568; /* text-gray-700 */
            font-size: 1rem; /* text-base */
            font-weight: 600; /* font-semibold */
            margin-bottom: 0.5rem; /* mb-2 */
            text-align: left; /* Align text to the left */
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
    <h1 class="text-4xl font-bold" style="font-family: 'Playfair Display', serif;">
     QuickQuote
    </h1>
    <p class="text-lg mt-2">
     Simplify Your Wedding Planning
    </p>
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
   <h2 class="text-3xl font-bold mb-6 text-center">
    Customer Dashboard
   </h2>
   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-concierge-bell text-3xl text-blue-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       View Services
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Browse and manage all your wedding service providers.
     </p>
     <a class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="service.php">
      Go to Services
     </a>
     </div>
     <div class="bg-white shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-tasks text-3xl text-blue-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Quotation
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      View your requests quotations.
     </p>
     <a href="quotation.php?customer_id=<?php echo isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : ''; ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
      View Quotation
     </a>
     </div>
     <div class="bg-white shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-shipping-fast text-3xl text-blue-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Order Tracking
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Track the status of your orders in real-time.
     </p>
     <?php if ($order_id): ?>
                    <a href="ordertracking.php?order_id=<?php echo $order_id; ?>" class="bg-blue-600 text-white py-2 px-4 rounded">Track Orders</a>
                <?php else: ?>
                    <p>No recent orders found.</p>
                <?php endif; ?>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-user-cog text-3xl text-blue-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Profile Settings
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Update your profile and account settings.
     </p>
     <a class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="customerprofile.php">
      Go to Profile
     </a>
    </div>
  </main>
  <footer class="bg-rose-300 text-gray-800 py-6 mt-auto">
   <div class="container mx-auto text-center">
    <p>
     © 2023 QuickQuote. All rights reserved.
    </p>
   </div>
  </footer>
 </body>
</html>