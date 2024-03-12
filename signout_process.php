<?php
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


// SQL query to insert data into the database
$sql = "INSERT INTO parent_child_details (parent_name, parent_address, parent_phone, parent_email, 
        child_name, child_gender, child_age, parent_age, baby_type) 
        VALUES ('$parent_name', '$parent_address', '$parent_phone', '$parent_email', 
        '$child_name', '$child_gender', '$child_age', '$parent_age', '$baby_type')";

if ($conn->query($sql) === TRUE) {
    echo "Signup successful. Thank you!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
[15:04]
parents
[15:04]
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Signup</title>
</head>
<body>
    <h2>Parent Signup</h2>
    <form action="signup_process.php" method="post">
        <label for="parent_name">Parent Name:</label>
        <input type="text" name="parent_name" required><br>

        <label for="parent_address">Parent Address:</label>
        <input type="text" name="parent_address" required><br>

        <label for="parent_phone">Phone Number:</label>
        <input type="tel" name="parent_phone" required><br>

        <label for="parent_email">Email:</label>
        <input type="email" name="parent_email" required><br>

        <label for="parent_password">Create Password:</label>
        <input type="password" name="parent_password" required><br>

        <label for="child_name">Child Name:</label>
        <input type="text" name="child_name" required><br>

        <label for="child_gender">Child Gender:</label>
        <select name="child_gender" required>
            <option value="boy">Boy</option>
            <option value="girl">Girl</option>
        </select><br>

        <label for="child_age">Child Age:</label>
        <input type="number" name="child_age" required><br>

        <label for="parent_age">Parent Age:</label>
        <input type="number" name="parent_age" required><br>

        <label for="baby_type">Baby Type:</label>
        <select name="baby_type" required>
            <option value="aggressive">Aggressive</option>
            <option value="soft">Soft</option>
            <option value="silent">Silent</option>
            <option value="funny">Funny</option>
            <option value="hyperactive">Hyperactive</option>
        </select><br>

        <?php
        ?>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>


