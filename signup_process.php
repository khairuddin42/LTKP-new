<?php
// Ensure session is started
session_start();

// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalproject";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and get the user_id from the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

echo "Debug: User ID from session: " . $user_id;

// Process the form data
$parent_name = mysqli_real_escape_string($conn, $_POST['parent_name']);
$parent_address = mysqli_real_escape_string($conn, $_POST['parent_address']);
$parent_phone = mysqli_real_escape_string($conn, $_POST['parent_phone']);
$parent_email = mysqli_real_escape_string($conn, $_POST['parent_email']);
$child_name = mysqli_real_escape_string($conn, $_POST['child_name']);
$child_gender = $_POST['child_gender'];
$child_age = $_POST['child_age'];
$parent_age = $_POST['parent_age'];
$baby_type = $_POST['baby_type'];

// Use prepared statements to prevent SQL injection
$sql = "INSERT INTO parent_child_details (user_id, parent_name, parent_address, parent_phone, parent_email, 
        child_name, child_gender, child_age, parent_age, baby_type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssssss", $user_id, $parent_name, $parent_address, $parent_phone, $parent_email, 
                                $child_name, $child_gender, $child_age, $parent_age, $baby_type);

// Execute the prepared statement
if ($stmt->execute()) {
    // Store the user's ID and details ID in session variables
    $_SESSION['details_id'] = $stmt->insert_id;

    echo "Debug: User details inserted successfully.";

    // Redirect to the profile page
    header("Location: profile.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>