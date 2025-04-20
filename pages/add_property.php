<?php
session_start();
require_once "../config/db.php";

// Redirect if not logged in or not owner/agent
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['owner', 'agent'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $location = $_POST['location'] ?? '';
    $image = $_FILES['image'] ?? null;

    if ($title && $description && $price && $location && $image && $image['error'] == 0) {
        $imageName = time() . "_" . basename($image['name']);
        $targetPath = "../uploads/" . $imageName;
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $sql = "INSERT INTO properties (user_id, title, description, price, location, image)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$_SESSION['user_id'], $title, $description, $price, $location, $imageName])) {
                $message = "Property added successfully!";
            } else {
                $message = "Error saving to database.";
            }
        } else {
            $message = "Image upload failed.";
        }
    } else {
        $message = "All fields are required and image must be valid.";
    }
}
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <h2>Add New Property</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Property</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
