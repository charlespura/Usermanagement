<?php
session_start();
require 'db_connection.php';
require 'user_sidebar.php';
$user_id = $_SESSION['user_id'];

// Get current data
$query = $pdo->prepare("SELECT username, full_name, email FROM users WHERE user_id = ?");
$query->execute([$user_id]);
$old = $query->fetch(PDO::FETCH_ASSOC);

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_full_name = $_POST['full_name'];
    $new_email = $_POST['email'];

    // Compare and log changes
    $fields = ['username', 'full_name', 'email'];
    foreach ($fields as $field) {
        if ($old[$field] !== $_POST[$field]) {
            $stmt = $pdo->prepare("INSERT INTO user_changes (user_id, field_changed, old_value, new_value) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $field, $old[$field], $_POST[$field]]);
        }
    }

    // Update user info
    $update = $pdo->prepare("UPDATE users SET username = ?, full_name = ?, email = ? WHERE user_id = ?");
    $update->execute([$new_username, $new_full_name, $new_email, $user_id]);

    // Set session success message
    $_SESSION['update_message'] = "✅ Information updated successfully.";

    // Redirect to refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
    }
    h2 {
        color: #333;
    }
    form {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: auto;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
    p {
        color: green;
        font-weight: bold;
        text-align: center;
    }
</style>
<h2>Edit My Info</h2>
<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($old['username']) ?>"><br>

    <label>Full Name:</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($old['full_name']) ?>"><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($old['email']) ?>"><br>

    <button type="submit">Save Changes</button>
</form>
<?php
// Display success message if available
if (isset($_SESSION['update_message'])) {
    echo "<p>{$_SESSION['update_message']}</p>";
    // Clear the message after displaying it
    unset($_SESSION['update_message']);
}
?>

