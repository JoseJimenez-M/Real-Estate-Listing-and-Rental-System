<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Real Estate System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/real_estate/index.php">Montreal Real-estate Agency</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/real_estate/pages/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/real_estate/pages/add_property.php">Add Property</a></li>
                    <li class="nav-item"><a class="nav-link" href="/real_estate/pages/view_property.php">View Properties</a></li>
                    <li class="nav-item"><a class="nav-link" href="/real_estate/pages/messages.php">Messages</a></li>

                    <?php if ($_SESSION['role'] === 'tenant'): ?>
                        <li class="nav-item"><a class="nav-link" href="/real_estate/pages/upload_agreement.php">Upload Agreement</a></li>
                    <?php endif; ?>

                    <?php if (in_array($_SESSION['role'], ['owner', 'agent'])): ?>
                        <li class="nav-item"><a class="nav-link" href="/real_estate/pages/view_rentals.php">View Agreements</a></li>
                    <?php endif; ?>

                    <li class="nav-item"><a class="nav-link text-danger" href="/real_estate/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/real_estate/pages/register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="/real_estate/pages/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
