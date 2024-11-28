<html>
 <head>
  <title>
   QuickQuote - Quote Details
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
            background-image: url('https://storage.googleapis.com/a1aa/image/wedding-background.jpg');
            background-size: cover;
            background-attachment: fixed;
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
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        main {
            flex: 1;
        }
        .details-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .details-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);
        }
        .details-card h3 {
            color: #e91e63; /* text-pink-600 */
        }
        .details-card p {
            color: #4A5568; /* text-gray-700 */
        }
        .details-card a {
            color: #3b82f6; /* text-blue-600 */
        }
        .details-card a:hover {
            text-decoration: underline;
        }
  </style>
 </head>
 <body>
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
    <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="request_qoute.php">
     Request Quotes
    </a>
    <a class="text-gray-800 px-4 py-2 hover:bg-rose-400" href="ordertracking.php">
     Order Tracking
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
    Quote Details
   </h2>
   <div class="details-card fade-in mx-auto w-full md:w-3/4 lg:w-1/2">
    <h3 class="text-2xl font-bold mb-4">
     Catering Service
    </h3>
    <p class="text-gray-700 mb-2">
     Status: <span class="font-bold text-green-600">Approved</span>
    </p>
    <p class="text-gray-700 mb-2">
     Quote Amount: $1500
    </p>
    <p class="text-gray-700 mb-2">
     Service Date: 2023-06-15
    </p>
    <p class="text-gray-700 mb-2">
     Service Provider: Gourmet Catering Co.
    </p>
    <p class="text-gray-700 mb-2">
     Contact: John Doe
    </p>
    <p class="text-gray-700 mb-2">
     Phone: (123) 456-7890
    </p>
    <p class="text-gray-700 mb-2">
     Email: johndoe@gourmetcatering.com
    </p>
    <p class="text-gray-700 mb-4">
     Additional Details: The catering service includes a full-course meal with appetizers, main courses, and desserts. Special dietary requirements will be accommodated.
    </p>
    <a class="text-blue-600 hover:underline" href="trackqoutes.php">
     Back to Quotes
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