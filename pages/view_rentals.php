<?php
session_start();
require_once "../config/db.php";

// Only allow agents or admins
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['agent', 'owner'])) {
    header("Location: login.php");
    exit();
}

$sql = "
SELECT r.*, p.title AS property_title, u.name AS tenant_name
FROM rentals r
JOIN properties p ON r.property_id = p.id
JOIN users u ON r.tenant_id = u.id
ORDER BY r.start_date DESC
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <h2>All Rental Agreements</h2>
    <?php if (empty($rentals)): ?>
        <p>No agreements uploaded yet.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($rentals as $r): ?>
                <li class="list-group-item">
                    <strong>Tenant:</strong> <?= htmlspecialchars($r['tenant_name']) ?><br>
                    <strong>Property:</strong> <?= htmlspecialchars($r['property_title']) ?><br>
                    <strong>From:</strong> <?= $r['start_date'] ?> to <?= $r['end_date'] ?><br>        
                    <a href="../uploads/<?= htmlspecialchars($r['document']) ?>" target="_blank">View Document</a>                    
                </li>                
            <?php endforeach; ?>            
        </ul>        
    <?php endif; ?>    
</div>

<?php include("../includes/footer.php"); ?>
