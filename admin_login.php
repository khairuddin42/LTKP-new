<?php
session_start();

// Check if the admin is already logged in, redirect to the dashboard if true
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

// Admin credentials
$admin_email = "admin@gmail.com";
$admin_password = "admin";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $input_email = $_POST["email"];
    $input_password = $_POST["password"];

    // Validate the credentials
    if ($input_email == $admin_email && $input_password == $admin_password) {
        // Set session variables to mark the admin as logged in
        $_SESSION['admin_logged_in'] = true;

        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style>
        .error-message {
            color: #ff0000; /* Red color for the error message */
            margin-top: 5px; /* Add a small margin to separate it from the inputs */
        }

        header, footer {
            background-color: #333; /* Dark background color for header and footer */
            color: #fff; /* White text color */
            padding: 10px 20px; /* Padding for header and footer */
        }
        main {
            flex: 1; /* Take up remaining vertical space */
            padding: 20px;
        }
    </style>
</head>
<body>
<header>
    <h1>Admin Login</h1>
</header>
<main>
    <?php
    // Display error message if there's an authentication error
    if (isset($error_message)) {
        echo "<p style='color: red;'>{$error_message}</p>";
    }
    ?>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</main>
</body>
</html>
