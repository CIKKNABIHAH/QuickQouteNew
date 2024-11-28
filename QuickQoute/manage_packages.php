<?php
session_start();
include 'db.php';

// Function to fetch all packages
function getPackages($conn) {
    $stmt = $conn->prepare("SELECT * FROM packages");
    $stmt->execute();
    $result = $stmt->get_result();
    $packages = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $packages;
}

// Function to edit a package
if (isset($_POST['edit_package'])) {
    $package_id = $_POST['package_id'];
    $service_id = $_POST['service_id'];
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $existing_image = $_POST['existing_image'];

    $image_url = $existing_image; // Use existing image by default

    // Check if a new image has been uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = 'uploads/images/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_url = $dest_path; // Update with new image path
            } else {
                echo 'Error moving the uploaded file';
                exit;
            }
        } else {
            echo 'Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions);
            exit;
        }
    }

    // Update the package details in the database
    $stmt = $conn->prepare("UPDATE packages SET service_id = ?, package_name = ?, description = ?, price = ?, image_url = ? WHERE package_id = ?");
    $stmt->bind_param("issdsi", $service_id, $package_name, $description, $price, $image_url, $package_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_packages.php?message=updated");
    exit;
}


// Function to add a package
if (isset($_POST['add_package'])) {
    $service_id = $_POST['service_id'];
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

        // Check if the file has an allowed extension
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Define the upload directory
            $uploadFileDir = 'uploads/images/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }
            $dest_path = $uploadFileDir . $fileName;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_url = $dest_path; // Save the path for database

                // Insert package details into the database
                $stmt = $conn->prepare("INSERT INTO packages (service_id, package_name, description, price, image_url) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issds", $service_id, $package_name, $description, $price, $image_url);
                $stmt->execute();
                $stmt->close();

                header("Location: manage_packages.php?message=added");
                exit;
            } else {
                echo 'Error moving the uploaded file';
            }
        } else {
            echo 'Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions);
        }
    } else {
        echo 'Error uploading the file';
    }
}

// Function to delete a package
if (isset($_GET['delete_id'])) {
    $package_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM packages WHERE package_id = ?");
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_packages.php?message=deleted");
    exit;
}

$packages = getPackages($conn);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages - QuickQuote</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #2d3748;
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
        }
        .content {
            margin-left: 250px; /* Adjust based on sidebar width */
            width: calc(100% - 250px);
            padding: 20px;
        }
        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #cbd5e0;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #4a5568;
        }
        .sidebar a.active {
            background-color: #4a5568;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');

            if (message === 'added') {
                alert('Package successfully added.');
            } else if (message === 'deleted') {
                alert('Package successfully deleted.');
            }
        };

        function openEditModal(package) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('package_id').value = package.package_id;
            document.getElementById('service_id').value = package.service_id;
            document.getElementById('package_name').value = package.package_name;
            document.getElementById('description').value = package.description;
            document.getElementById('price').value = package.price;
            document.getElementById('existing_image').value = package.image_url;
        }

        window.onload = function() {
            document.getElementsByClassName('close-button')[0].onclick = function() {
                document.getElementById('editModal').style.display = 'none';
            }
            window.onclick = function(event) {
                if (event.target == document.getElementById('editModal')) {
                    document.getElementById('editModal').style.display = 'none';
                }
            }
        };
    </script>
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4">
            <h1 class="text-2xl font-bold">QuickQuote Admin</h1>
        </div>
        <ul class="mt-6">
            <li><a href="admindashboard.php" class="flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
            <li><a href="manage_services.php" class="flex items-center"><i class="fas fa-cogs mr-2"></i>Manage Services</a></li>
            <li><a href="manage_packages.php" class="flex items-center active"><i class="fas fa-box mr-2"></i>Manage Packages</a></li>
            <li><a href="manage_customers.php" class="flex items-center"><i class="fas fa-users mr-2"></i>Manage Customers</a></li>
            <li><a href="manageorders.php" class="flex items-center"><i class="fas fa-shopping-cart mr-2"></i>Manage Orders</a></li>
            <li><a href="admin_update_tracking.php" class="flex items-center"><i class="fas fa-shipping-fast mr-2"></i>Update Order Status</a></li>
            <li><a href="settings.php" class="flex items-center"><i class="fas fa-cog mr-2"></i>Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold">Manage Packages</h2>
            <div class="flex items-center">
                <span class="mr-4">Admin</span>
                <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded-full">Logout</a>
            </div>
        </header>
        <!-- Content -->
        <main class="p-6">
            <div class="container mx-auto py-10">
                <h2 class="text-3xl font-bold mb-6 text-center">Manage Packages</h2>

                <!-- Add Package Form -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-2xl font-bold mb-4">Add New Package</h3>
                    <form action="manage_packages.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="add_package" value="1">
                        <div class="mb-4">
                            <label for="service_id" class="block font-semibold">Service ID</label>
                            <input type="number" name="service_id" id="service_id" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="package_name" class="block font-semibold">Package Name</label>
                            <input type="text" name="package_name" id="package_name" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block font-semibold">Description</label>
                            <textarea name="description" id="description" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block font-semibold">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block font-semibold">Image</label>
                            <input type="file" name="image" id="image" class="w-full p-2 border rounded" accept="image/*" required>
                        </div>
                        <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded">Add Package</button>
                    </form>
                </div>

                <!-- Edit Modal -->
                <div id="editModal" class="modal">
                    <div class="modal-content">
                        <span class="close-button">×</span>
                        <h2>Edit Package</h2>
                        <form action="manage_packages.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="edit_package" value="1">
                            <input type="hidden" name="package_id" id="package_id">
                            <div>
                                <label>Service ID:</label>
                                <input type="number" name="service_id" id="service_id" required>
                            </div>
                            <div>
                                <label>Package Name:</label>
                                <input type="text" name="package_name" id="package_name" required>
                            </div>
                            <div>
                                <label>Description:</label>
                                <textarea name="description" id="description" required></textarea>
                            </div>
                            <div>
                                <label>Price:</label>
                                <input type="number" name="price" id="price" step="0.01" required>
                            </div>
                            <div>
                                <label>Image (leave blank to keep current image):</label>
                                <input type="file" name="image" id="image">
                                <input type="hidden" name="existing_image" id="existing_image">
                            </div>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Package</button>
                        </form>
                    </div>
                </div>

                <!-- Packages Table -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-2xl font-bold mb-4">Packages List</h3>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Service ID</th>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Description</th>
                                <th class="py-2 px-4 border-b">Price</th>
                                <th class="py-2 px-4 border-b">Image</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($packages as $package): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b"><?php echo $package['package_id']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo $package['service_id']; ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($package['package_name']); ?></td>
                                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($package['description']); ?></td>
                                    <td class="py-2 px-4 border-b">RM<?php echo number_format($package['price'], 2); ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <img src="<?php echo htmlspecialchars($package['image_url']); ?>" alt="Image of <?php echo htmlspecialchars($package['package_name']); ?>" width="50" height="50">
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="edit_package.php?package_id=<?php echo $package['package_id']; ?>" class="text-blue-500 font-bold">Edit</a>
                                        <a href="manage_packages.php?delete_id=<?php echo $package['package_id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-500 font-bold">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
