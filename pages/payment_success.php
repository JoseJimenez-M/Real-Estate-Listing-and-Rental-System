<?php
session_start();
require_once "../config/db.php";
require_once "../config/telegram_notify.php";
sendTelegramMessage("Payment succesful for Property ID #$property_id for user ID #$user_id");

$rental_id = $_GET['rental_id'] ?? null;
if (!$rental_id) {
    header("Location: ../index.php");
    exit;
}

$stmt = $conn->prepare("UPDATE rentals SET PaymentState = 1 WHERE id = ?");
$stmt->execute([$rental_id]);

?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <div class="alert alert-success">
        ¡Payment succesful! Book confirmed.
    </div>
    <a href="../pages/upload_agreement.php" class="btn btn-primary">See my rentals</a>
</div>



<?php include("../includes/footer.php"); ?>
