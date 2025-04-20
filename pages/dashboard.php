<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("../includes/header.php");
?>



<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
    <p>Your role: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>

    <div class="mt-4">
        <a href="add_property.php" class="btn btn-primary">Add Property</a>
        <a href="view_property.php" class="btn btn-secondary">View My Properties</a>
        <a href="messages.php" class="btn btn-info">Messages</a>
        <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
