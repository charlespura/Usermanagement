<?php
session_start();
require 'db_connection.php';

if (isset($_SESSION['user_id'])) {
    // Update logout time
    $stmt = $pdo->prepare("
        UPDATE user_sessions
        SET logout_time = CURRENT_TIMESTAMP
        WHERE user_id = ? AND logout_time IS NULL
        ORDER BY login_time DESC LIMIT 1
    ");
    $stmt->execute([$_SESSION['user_id']]);
}

session_destroy();
header("Location: login.php");
exit;
?>
