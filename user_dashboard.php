<?php
session_start();
require 'db_connection.php';
require 'user_sidebar.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT username, full_name, email, created_at FROM users WHERE user_id = ?");
$query->execute([$user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-content">
    <h1>Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h1>
    <p>Your username: <?= htmlspecialchars($user['username']) ?></p>
    <p>Your email: <?= htmlspecialchars($user['email']) ?></p>
    <p>Account created on: <?= htmlspecialchars($user['created_at']) ?></p>

    <h2>Available Actions</h2>
    <ul>
        <li><a href="view_user.php">View My Information</a></li>
        <li><a href="edit_user.php">Edit My Information</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

</body>
</html>