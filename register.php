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

<div style="text-align: center; margin-bottom: 20px;">
    <h2>Register</h2>
</div>
<form method="POST" style="max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
    <div style="margin-bottom: 15px;">
        <label for="username" style="display: block; font-weight: bold;">Username</label>
        <input type="text" id="username" name="username" placeholder="Username" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="full_name" style="display: block; font-weight: bold;">Full Name</label>
        <input type="text" id="full_name" name="full_name" placeholder="Full Name" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="email" style="display: block; font-weight: bold;">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="password" style="display: block; font-weight: bold;">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <button type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px;">Register</button>
</form>

<!-- Button to go to Login Page -->
<p style="text-align: center; margin-top: 15px;">Already have an account? <a href="login.php" style="color: #4CAF50; text-decoration: none; font-weight: bold;">Login Here</a></p>

