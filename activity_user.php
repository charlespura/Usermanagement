<?php
session_start();
include 'db_connection.php';
include 'admin_sidebar.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: user_dashboard.php');
    exit();
}

// Fetch Active Sessions
$stmt_sessions = $pdo->prepare("SELECT * FROM user_sessions WHERE logout_time IS NULL");
$stmt_sessions->execute();
$active_sessions = $stmt_sessions->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Active User Sessions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .main-content {
            padding: 20px;
          
        
       
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            color: #343a40;
        }

        /* Table container */
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        /* Styled table */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .admin-table th, .admin-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .admin-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .admin-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .admin-table tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="main-content">
    <h1>Active User Sessions</h1>
    <p>Below are the currently active user sessions.</p>

    <div class="table-container">
        <table class="admin-table">
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
                        <td><?php echo htmlspecialchars($session['session_id']); ?></td>
                        <td><?php echo htmlspecialchars($session['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($session['login_time']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
