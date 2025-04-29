<?php
$host = 'localhost';       // or your server IP
$db   = 'userdb';         // your database name
$user = 'root';            // your MySQL username (often 'root' in local dev)
$pass = '';                // your MySQL password (empty for XAMPP/WAMP)
$charset = 'utf8mb4';

// Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // for error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch as associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // use native prepares
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
