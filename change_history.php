<?php
session_start();
require 'db_connection.php';
require 'admin_sidebar.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

// Fetch user change history
$query = $pdo->query("
    SELECT 
        uc.change_id,
        u.username AS user,
        uc.field_changed,
        uc.old_value,
        uc.new_value,
        uc.changed_at
    FROM user_changes uc
    JOIN users u ON uc.user_id = u.user_id
    ORDER BY uc.changed_at DESC
");
$changes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Change History</title>
    <link rel="stylesheet" href="style.css">

    <style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        color: #333;
    }

    .main-content {
        padding: 20px;
    }

    h1, h2 {
        color: #343a40;
    }

    /* Style for the table container */
    .table-container {
        margin: 20px 0;
    }

    .table-container h2 {
        margin-bottom: 10px;
        color: #007bff;
    }

    /* Style for the admin table */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .admin-table th, .admin-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .admin-table th {
        background-color: #f4f4f4;
        font-weight: bold;
        color: #343a40;
    }

    .admin-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .admin-table tr:hover {
        background-color: #f1f1f1;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .table-container {
            overflow-x: auto;
        }
    }
    </style>

</head>
<body>

    <div class="main-content">
        <h1>User Change History</h1>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Field Changed</th>
                        <th>Old Value</th>
                        <th>New Value</th>
                        <th>Changed At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($changes as $change): ?>
                        <tr>
                            <td><?= htmlspecialchars($change['user']) ?></td>
                            <td><?= htmlspecialchars($change['field_changed']) ?></td>
                            <td><?= htmlspecialchars($change['old_value']) ?></td>
                            <td><?= htmlspecialchars($change['new_value']) ?></td>
                            <td><?= htmlspecialchars($change['changed_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
