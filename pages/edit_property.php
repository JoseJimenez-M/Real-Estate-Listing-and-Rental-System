<?php
session_start();
require_once "../config/db.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET['id'] ?? null;
$message = "";

// Fetch property details
if ($property_id) {
    $sql = "SELECT * FROM properties WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$property_id, $user_id]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$property) {
        die("Property not found or unauthorized.");
    }
} else {
    die("No property ID provided.");
}

// Update logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $location = $_POST['location'] ?? '';
    $imageName = $property['image']; // keep old image by default

    // If new image uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
    }

    $sql = "UPDATE properties SET title = ?, description = ?, price = ?, location = ?, image = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$title, $description, $price, $location, $imageName, $property_id, $user_id])) {
        $message = "Property updated successfully!";
        // Refresh property data
        $property['title'] = $title;
        $property['description'] = $description;
        $property['price'] = $price;
        $property['location'] = $location;
        $property['image'] = $imageName;
    } else {
        $message = "Error updating property.";
    }
}
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <h2>Edit Property</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($property['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($property['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($property['price']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($property['location']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="../uploads/<?= htmlspecialchars($property['image']) ?>" width="150">
        </div>
        <div class="mb-3">
            <label>Change Image (optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update Property</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
