<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_POST['user_id']) && isset($_POST['about_text'])) {
    $user_id = $_POST['user_id'];
    $about_text = $_POST['about_text'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "finalproject";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update or insert about user details
    $sql = "INSERT INTO about_user (user_id, about_text) VALUES (?, ?) ON DUPLICATE KEY UPDATE about_text = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $about_text, $about_text);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}
?>
