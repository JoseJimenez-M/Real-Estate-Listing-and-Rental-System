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

if ($property_id) {
    // Optional: Get image name to delete file later (not required)
    $stmt = $conn->prepare("SELECT image FROM properties WHERE id = ? AND user_id = ?");
    $stmt->execute([$property_id, $user_id]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($property) {
        $stmt = $conn->prepare("DELETE FROM properties WHERE id = ? AND user_id = ?");
        $stmt->execute([$property_id, $user_id]);

        // Optionally delete image file
        $imagePath = "../uploads/" . $property['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}

header("Location: view_property.php");
exit();
