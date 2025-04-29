<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = $_POST['username'];
    $full_name  = $_POST['full_name'];
    $email      = $_POST['email'];
    $password   = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username/email already exists
    $check = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $check->execute([$username, $email]);

    if ($check->rowCount() > 0) {
        echo "❌ Username or email already exists.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, full_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $full_name, $email, $password]);
        echo "✅ Registration successful. <a href='login.php'>Login here</a>";
    }
}
?>

<h2>Register</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="text" name="full_name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>

<!-- Button to go to Login Page -->
<p>Already have an account? <a href="login.php"><button>Login Here</button></a></p>
