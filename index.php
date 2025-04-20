<?php include("includes/header.php"); ?>

<div class="container mt-5 text-center">
    <h1>Welcome to the Real Estate Listing & Rental System</h1>
    <p class="lead">List, rent, and manage properties easily and securely.</p>
    
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="pages/register.php" class="btn btn-success">Get Started</a>
        <a href="pages/login.php" class="btn btn-primary">Login</a>
    <?php else: ?>
        <a href="pages/dashboard.php" class="btn btn-info">Go to Dashboard</a>
    <?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>
