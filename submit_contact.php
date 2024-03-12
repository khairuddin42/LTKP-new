<?php
// Start the session
session_start();

// Include the database connection file
include('database.php');

// Assume you have user authentication and user_id available in your session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Update this line based on your authentication mechanism

// Check if $user_id is not null before proceeding
if ($user_id !== null) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert comment into the database
    $sql = "INSERT INTO user_comments (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Thank You For Giving Us Your Comment. We Will Take Your Comment To Improve Our Website.'); window.location.href='Contacts.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Error: User not authenticated.";
}

// Close the database connection
$conn->close();
?>
