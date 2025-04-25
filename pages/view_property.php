<?php
session_start();
require_once "../config/db.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Pagination setup
$page = $_GET['page'] ?? 1;
$limit = 6;
$offset = ($page - 1) * $limit;

// Search
$search = $_GET['search'] ?? '';
$searchTerm = "%$search%";

// Get properties based on role
if ($role === 'tenant') {
    // Tenants see all listings
    $sql = "SELECT * FROM properties WHERE title LIKE ? OR location LIKE ? LIMIT $limit OFFSET $offset";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$searchTerm, $searchTerm]);

    $countSql = "SELECT COUNT(*) FROM properties WHERE title LIKE ? OR location LIKE ?";
    $countStmt = $conn->prepare($countSql);
    $countStmt->execute([$searchTerm, $searchTerm]);
} else {
    // Owners/Agents see their own listings
    $sql = "SELECT * FROM properties WHERE user_id = ? AND (title LIKE ? OR location LIKE ?) LIMIT $limit OFFSET $offset";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $searchTerm, $searchTerm]);

    $countSql = "SELECT COUNT(*) FROM properties WHERE user_id = ? AND (title LIKE ? OR location LIKE ?)";
    $countStmt = $conn->prepare($countSql);
    $countStmt->execute([$user_id, $searchTerm, $searchTerm]);
}

$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $limit);
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <h2><?= $role === 'tenant' ? 'Available Properties' : 'My Listed Properties' ?></h2>

    <!-- Search Form -->
    <form method="get" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Search by title or location" value="<?= htmlspecialchars($search) ?>">
    </form>

    <?php if (count($properties) === 0): ?>
        <p>No properties found.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($properties as $property): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="../uploads/<?= htmlspecialchars($property['image']) ?>" class="card-img-top" alt="Property Image" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($property['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($property['location']) ?></p>
                            <p class="card-text"><strong>Price:</strong> $<?= htmlspecialchars($property['price']) ?></p>
                            <p class="card-text"><?= htmlspecialchars($property['description']) ?></p>

                            <?php if (in_array($role, ['owner', 'agent']) && $property['user_id'] == $user_id): ?>
                                <a href="edit_property.php?id=<?= $property['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_property.php?id=<?= $property['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>
