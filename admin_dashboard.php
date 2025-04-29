<?php
session_start();
include 'db_connection.php';
include 'admin_sidebar.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: logout.php');
    exit();
}

// Fetch Users Count (active)
$stmt_users = $pdo->prepare("SELECT COUNT(*) as total_users FROM users WHERE role = 'user'");
$stmt_users->execute();
$user_count = $stmt_users->fetch();

// Fetch User Changes
$stmt_changes = $pdo->prepare("SELECT * FROM user_changes ORDER BY changed_at DESC LIMIT 5");
$stmt_changes->execute();
$changes = $stmt_changes->fetchAll();

// Fetch Active Sessions
$stmt_sessions = $pdo->prepare("SELECT * FROM user_sessions WHERE logout_time IS NULL");
$stmt_sessions->execute();
$active_sessions = $stmt_sessions->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .main-content { padding: 20px; }
        .card-container { display: flex; }
        .card { padding: 20px; margin-right: 20px; border: 1px solid #ddd; border-radius: 5px; width: 200px; }
        .table-container { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 12px; border: 1px solid #ddd; text-align: left; }
        .stat-number { font-size: 32px; font-weight: bold; }
    </style>
</head>
<body>

<div class="main-content">
    <h1>Welcome to Your Dashboard</h1>
    <p>Select a feature from the sidebar to begin.</p>

    <!-- Card Summary Section -->
    <div class="card-container">
        <!-- Total Users Card -->
        <div class="card card-1">
            <h3>Total Active Users</h3>
            <p class="stat-number"><?php echo $user_count['total_users']; ?></p>
            <p style="color: gray;">As of today</p>
        </div>

        <!-- Admin Account Info Card -->
        <div class="card card-2">
            <h3>Account</h3>
            <p style="font-size: 18px;"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p style="color: gray;">Role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
        </div>
    </div>

    <!-- User Changes Section -->
    <div class="table-container">
        <h2>Recent User Changes</h2>
        <table>
            <thead>
                <tr>
                    <th>Change ID</th>
                    <th>User ID</th>
                    <th>Field Changed</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                    <th>Changed At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($changes as $change): ?>
                    <tr>
                        <td><?php echo $change['change_id']; ?></td>
                        <td><?php echo $change['user_id']; ?></td>
                        <td><?php echo $change['field_changed']; ?></td>
                        <td><?php echo $change['old_value']; ?></td>
                        <td><?php echo $change['new_value']; ?></td>
                        <td><?php echo $change['changed_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Active Sessions Section -->
    <div class="table-container">
        <h2>Active User Sessions</h2>
        <table>
            <thead>
                <tr>
                    <th>Session ID</th>
                    <th>User ID</th>
                    <th>Login Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($active_sessions as $session): ?>
                    <tr>
                        <td><?php echo $session['session_id']; ?></td>
                        <td><?php echo $session['user_id']; ?></td>
                        <td><?php echo $session['login_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
