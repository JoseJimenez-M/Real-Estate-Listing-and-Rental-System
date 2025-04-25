<?php
session_start();
require_once "../config/db.php";

// Only tenants allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'tenant') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Get all available properties to rent
$propertiesStmt = $conn->prepare("SELECT id, title FROM properties");
$propertiesStmt->execute();
$properties = $propertiesStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle upload
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $property_id = $_POST['property_id'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $doc = $_FILES['document'] ?? null;

    if ($property_id && $start_date && $end_date && $doc && $doc['error'] === 0) {

          $checkSql = "
            SELECT COUNT(*) 
            FROM rentals 
            WHERE property_id = ? 
            AND (
                (start_date <= ? AND end_date >= ?) OR 
                (start_date <= ? AND end_date >= ?)
            )
        ";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->execute([$property_id, $start_date, $start_date, $end_date, $end_date]);
        $conflictCount = $checkStmt->fetchColumn();

        if ($conflictCount > 0) {
            $message = "The selected dates conflict with an existing rental agreement. Please contact the owner by private message for more avalibles dates or try again";
        } else {
            $docName = time() . "_" . basename($doc['name']);
            $targetPath = "../uploads/" . $docName;

            if (move_uploaded_file($doc['tmp_name'], $targetPath)) {
                $sql = "INSERT INTO rentals (property_id, tenant_id, start_date, end_date, document)
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute([$property_id, $user_id, $start_date, $end_date, $docName])) {
                    $message = "Rental agreement uploaded successfully!";
                } else {
                    $message = "Failed to save rental agreement.";
                }
            } else {
                $message = "File upload failed.";
            }
        }
    } else {
        $message = "Please fill in all fields and upload a valid document.";
    }
}

// Fetch uploaded agreements by this tenant
$rentalsStmt = $conn->prepare("
    SELECT r.*, r.property_id, p.title AS property_title
    FROM rentals r
    JOIN properties p ON r.property_id = p.id
    WHERE r.tenant_id = ?
");
$rentalsStmt->execute([$user_id]);
$rentals = $rentalsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">

<?php if (isset($_GET['paid']) && $_GET['paid'] == 1): ?>
    <div class="alert alert-success">Payment completed successfully!</div>
<?php endif; ?>

    <h2>Upload Rental Agreement</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <!-- Upload Form -->
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Property</label>
            <select name="property_id" class="form-control" required>
                <option value="">-- Select Property --</option>
                <?php foreach ($properties as $prop): ?>
                    <option value="<?= $prop['id'] ?>"><?= htmlspecialchars($prop['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Rental Agreement (PDF/Doc)</label>
            <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Agreement</button>
    </form>

    <!-- Show Uploaded Agreements -->
    <h4 class="mt-5">Your Uploaded Agreements</h4>
    <?php if (empty($rentals)): ?>
        <p>No agreements uploaded yet.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($rentals as $r): ?>
                <li class="list-group-item">
                    <strong>Property:</strong> <?= htmlspecialchars($r['property_title']) ?><br>
                    <strong>Start:</strong> <?= $r['start_date'] ?> |
                    <strong>End:</strong> <?= $r['end_date'] ?><br>
            <!--button and check-->
                            <?php  if (!$r['PaymentState']): ?>
                                <a href="../pages/checkout.php?rental_id=<?= $r['id'] ?>" class="btn btn-success">Pay now</a>
                            <?php else: ?>
                                <span class="badge bg-secondary">Paid</span>
                            <?php endif; ?>
                    <br>
                    <a href="../uploads/<?= htmlspecialchars($r['document']) ?>" target="_blank">View Document</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>
