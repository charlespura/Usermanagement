<?php
session_start();
require 'db_connection.php'; // your database connection
require 'user_sidebar.php';
$user_id = $_SESSION['user_id'];

$query = $pdo->prepare("SELECT username, full_name, email, created_at, updated_at FROM users WHERE user_id = ?");
$query->execute([$user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);
?>
<div class="main-content">
    <div class="table-container">
        <h2>My Information</h2>
        <div class="info-card">
            <ul>
                <li><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></li>
                <li><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                <li><strong>Account Created:</strong> <?= htmlspecialchars($user['created_at']) ?></li>
                <li><strong>Last Updated:</strong> <?= htmlspecialchars($user['updated_at']) ?></li>
            </ul>
        </div>
    </div>
</div>

<style>
/* Styling for Information Card */
.info-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    color: #343a40;
}

.info-card ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.info-card li {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    font-size: 16px;
}

.info-card li:last-child {
    border-bottom: none;
}

.info-card strong {
    color: #007bff;
}
</style>
