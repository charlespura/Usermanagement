<?php
session_start();
include 'db_connection.php';
include 'admin_sidebar.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: user_dashboard.php');
    exit();
}

$edit_user = null; // For edit form prefill

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Save Edit
    if (isset($_POST['save_edit'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $stmt = $pdo->prepare("UPDATE users SET username = ?, full_name = ?, email = ?, role = ? WHERE user_id = ?");
        $stmt->execute([$username, $full_name, $email, $role, $user_id]);

        $_SESSION['success_message'] = "User updated successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle Edit Button Click - Show the form
    if (isset($_POST['request_edit'])) {
        $user_id = $_POST['user_id'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $edit_user = $stmt->fetch();
    }

    // Handle Delete User
    if (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $_SESSION['success_message'] = "User deleted successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch all users
$stmt_users = $pdo->prepare("SELECT * FROM users");
$stmt_users->execute();
$users = $stmt_users->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User Information</title>
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
            color: #333;
        }
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[name="request_edit"] {
            background-color: #007bff;
            color: white;
        }
        button[name="delete_user"] {
            background-color: #dc3545;
            color: white;
        }
        button:hover {
            opacity: 0.9;
        }
        .form-container {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="text"]:focus, input[type="email"]:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }
        button[name="save_edit"] {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>

<div class="main-content">
    <h1>Manage Users</h1>
    <p>Below are the users, you can edit or delete their information.</p>

    <!-- Users Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['full_name']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <!-- Edit User Form -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" name="request_edit">Edit</button>
                            </form>
                            <!-- Delete User Form -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" name="delete_user" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($edit_user)): ?>
    <div class="form-container">
        <h2>Edit User</h2>
        <form method="POST" action="">
            <input type="hidden" name="user_id" value="<?php echo $edit_user['user_id']; ?>">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $edit_user['username']; ?>" required>

            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $edit_user['full_name']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $edit_user['email']; ?>" required>

            <label>Role:</label>
            <select name="role">
                <option value="user" <?php if ($edit_user['role'] === 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($edit_user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
            </select>

            <button type="submit" name="save_edit">Save Changes</button>
        </form>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
