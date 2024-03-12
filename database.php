<?php
// Database credentials
$host = 'localhost'; // Host name
$db_user = 'root'; // Database username
$db_password = ''; // Database password
$db_name = 'finalproject'; // Database name

// Create MySQLi connection
$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Create PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check MySQLi connection
if ($conn->connect_error) {
    die("MySQLi Connection failed: " . $conn->connect_error);
}
?>