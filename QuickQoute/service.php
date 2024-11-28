<html>
 <head>
  <title>
   QuickQuote - Services
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        main {
            flex: 1;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
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
    Services
   </h2>
   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-utensils text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Catering
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Find the best catering services for your wedding.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="cateringservice.php">
      View Catering Services
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-music text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Music & Entertainment
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Discover top music and entertainment options.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="entertainment.php">
      View Music & Entertainment
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-camera text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Photography
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Hire the best photographers for your special day.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="photographservice.php">
      View Photography Services
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-birthday-cake text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Cakes & Desserts
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Explore delicious cake and dessert options.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="cake&dessert.php">
      View Cakes & Desserts
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-car text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Transportation
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Arrange transportation for your wedding day.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="transportation.php">
      View Transportation Services
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-heart text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Wedding Themes
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Explore various wedding themes to make your day special.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="weddingtheme.php">
      View Wedding Themes
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-gift text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Wedding Goodies
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Find the perfect wedding goodies and favors.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="weddinggoodies.php">
      View Wedding Goodies
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-paint-brush text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Make Up
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Find the best make-up artists for your wedding.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="makeup.php">
      View Make Up Services
     </a>
    </div>
    <div class="card shadow-lg rounded-lg p-6 fade-in">
     <div class="flex items-center mb-4">
      <i class="fas fa-tshirt text-3xl text-pink-600 mr-4"></i>
      <h3 class="text-xl font-bold">
       Dress/Suite
      </h3>
     </div>
     <p class="text-gray-700 mb-4">
      Find the perfect dress or suite for your wedding.
     </p>
     <a class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" href="dress&suite.php">
      View Dress/Suite Services
     </a>
    </div>
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