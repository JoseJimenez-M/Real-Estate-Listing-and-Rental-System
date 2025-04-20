<?php
require_once "../config/db.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'tenant';

    if (!empty($name) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$name, $email, $hashed_password, $role])) {
            $message = "User registered successfully!";
        } else {
            $message = "Error registering user.";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>

<?php include("../includes/header.php"); ?>

<div class="container mt-5">
    <h2>User Registration</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
        <?php if ($message === "User registered successfully!"): ?>
            <a href="login.php" class="btn btn-success mt-2">Go to Login</a>
        <?php endif; ?>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="tenant">Tenant</option>
                <option value="owner">Owner</option>
                <option value="agent">Agent</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
