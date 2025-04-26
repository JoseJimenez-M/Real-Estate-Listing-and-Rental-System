<?php
session_start();
require_once "../config/db.php";
require_once "../config/telegram_notify.php";

$rental_id = $_GET['rental_id'] ?? null;
if (!$rental_id) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;

$stmt = $conn->prepare("SELECT property_id FROM rentals WHERE id = ?");
$stmt->execute([$rental_id]);
$rental = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rental) {
    die("Rental not found.");
}

$property_id = $rental['property_id'];

$stmt = $conn->prepare("UPDATE rentals SET PaymentState = 1 WHERE id = ?");
$stmt->execute([$rental_id]);

sendTelegramMessage("Payment successful!\n Property ID: #$property_id\n User ID: #$user_id");

?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <div class="alert alert-success">
        ¡Payment successful! Booking confirmed.
    </div>
    <a href="../pages/upload_agreement.php" class="btn btn-primary">See my rentals</a>
</div>

<?php include("../includes/footer.php"); ?>
