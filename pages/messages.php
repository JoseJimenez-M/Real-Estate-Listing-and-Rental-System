<?php
session_start();
require_once "../config/db.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$messageStatus = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $receiver_id = $_POST['receiver_id'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($receiver_id) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$user_id, $receiver_id, $message])) {
            $messageStatus = "Message sent successfully!";
        } else {
            $messageStatus = "Failed to send message.";
        }
    } else {
        $messageStatus = "All fields are required.";
    }
}

// Get list of users (excluding current user)
$usersStmt = $conn->prepare("SELECT id, name, role FROM users WHERE id != ?");
$usersStmt->execute([$user_id]);
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch received messages
$receivedStmt = $conn->prepare("SELECT m.*, u.name AS sender_name FROM messages m JOIN users u ON m.sender_id = u.id WHERE m.receiver_id = ? ORDER BY m.sent_at DESC");
$receivedStmt->execute([$user_id]);
$receivedMessages = $receivedStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <h2>Messages</h2>

    <?php if ($messageStatus): ?>
        <div class="alert alert-info"><?= $messageStatus ?></div>
    <?php endif; ?>

    <!-- Message Form -->
    <form method="post" class="mb-4">
        <div class="mb-3">
            <label>Send To:</label>
            <select name="receiver_id" class="form-control" required>
                <option value="">-- Select User --</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> (<?= $u['role'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Your Message:</label>
            <textarea name="message" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>

    <!-- Received Messages -->
    <h4>Inbox</h4>
    <?php if (empty($receivedMessages)): ?>
        <p>No messages received yet.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($receivedMessages as $msg): ?>
                <li class="list-group-item">
                    <strong>From:</strong> <?= htmlspecialchars($msg['sender_name']) ?><br>
                    <strong>Message:</strong> <?= htmlspecialchars($msg['message']) ?><br>
                    <small class="text-muted"><?= $msg['sent_at'] ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>
