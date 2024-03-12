<?php
session_start();

$login_error = ""; // Initialize login error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'database.php'; // File to connect to your database

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check the credentials using prepared statement
    $query = "SELECT user_id, email, password_hash FROM user_registration WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password_hash'])) {
            // Password is correct, start a new session
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_id'] = $row['user_id'];

            echo "Debug: User ID in session: " . $_SESSION['user_id'];

            header("Location: homepage.php"); // Redirect to a welcome page after successful login
            exit();
        } else {
            $login_error = "Incorrect email and/or password!";
        }
    } else {
        $login_error = "Incorrect email and/or password!";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login to LTKP</title>
    <link rel="stylesheet" href="login.css">
    <style>
        .error-message {
            color: #ff0000; /* Red color for the error message */
            margin-top: 5px; /* Add a small margin to separate it from the inputs */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="LTKP logo.jpg" alt="LTKP Logo" class="logo"> <!-- Add this line for the logo -->
        
        <p class="subtitle">Log in to LTKP</p>

        <form action="login.php" method="post" class="login-form">
            <input type="email" id="email" name="email" placeholder="E-mail address" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            
            <!-- Display styled validation error message -->
            <p class="error-message"><?php echo $login_error; ?></p>
            
            <button type="submit">Log in</button>
        </form>

        <div class="forgot-signup">
            <a href="reset_request.php">Forgot password?</a>
            <p>No account yet? <a href="register.php">Sign up here</a></p>
            <p>Are you admin? <a href="admin_login.php">Click here</a></p>
        </div>
    </div>
</body>
</html>
