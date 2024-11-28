<?php
session_start();
include 'db.php';

$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : null;
$package = null;

// Fetch package data for editing
if ($package_id) {
    $stmt = $conn->prepare("SELECT * FROM packages WHERE package_id = ?");
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $package = $result->fetch_assoc();
    $stmt->close();
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_package'])) {
    $service_id = $_POST['service_id'];
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $existing_image = $_POST['existing_image'];

    // Image processing
    $image_url = $existing_image;
    if (!empty($_FILES['image']['name'])) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = 'uploads/images/';
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_url = $dest_path;
            }
        }
    }

    // Update the package
    $stmt = $conn->prepare("UPDATE packages SET service_id=?, package_name=?, description=?, price=?, image_url=? WHERE package_id=?");
    $stmt->bind_param("issdsi", $service_id, $package_name, $description, $price, $image_url, $package_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_packages.php?message=Package updated successfully");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package - QuickQuote</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="w-full max-w-xl bg-white rounded-lg shadow-md p-5 mx-auto my-10">
            <h2 class="text-center text-2xl font-bold mb-6">Edit Package</h2>
            <?php if ($package): ?>
            <form action="edit_package.php?package_id=<?php echo $package_id; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_package" value="1">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="service_id">Service ID</label>
                    <input type="number" id="service_id" name="service_id" value="<?php echo htmlspecialchars($package['service_id']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="package_name">Package Name</label>
                    <input type="text" id="package_name" name="package_name" value="<?php echo htmlspecialchars($package['package_name']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                    <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><?php echo htmlspecialchars($package['description']); ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                    <input type of="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($package['price']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image (optional, current shown below)</label>
                    <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <?php if ($package['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($package['image_url']); ?>" alt="Current Image" class="mt-2 w-24 h-24 object-cover">
                    <?php endif; ?>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Package</button>
            </form>
            <?php else: ?>
            <p>Package not found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
