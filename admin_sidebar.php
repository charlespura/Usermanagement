<!-- sidebar.php -->
<?php
include "db_connection.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Human Resource Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<button class="menu-toggle" onclick="toggleSidebar()">☰</button>

<aside class="sidebar" id="sidebar">
<div class="sidebar-header" style="display: flex; align-items: center; gap: 10px;  margin-top: 80px; margin-bottom: 30px;">
  
  <h2 style="margin: 0; color: var(--primary-color); font-weight: 600;">Risk Management</h2>
</div>


  <ul class="sidebar-menu">
  <li><a href="admin_dashboard.php"><span>📊</span> Dashboard</a></li>

  <li><a href="change_history.php"><span>📜</span> Change History</a></li>
  <li><a href="activity_user.php"><span>👥</span> Show User Session</a></li>
  <li><a href="edit_user_info.php"><span>🛠️</span> Edit User Info</a></li>


    <li><a href="logout.php"><span>🚪</span> Logout </a></li>
  </ul>
</aside>

<script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('closed');
  }
</script>

</body>
</html>
