<?php
session_start();
require 'database.php';

if (!isset($_SESSION['valid_otp']) || !$_SESSION['valid_otp']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['reset_email'];
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE user_registration SET password_hash = ?, otp = NULL, otp_expiry = NULL WHERE email = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ss', $hashedPassword, $email);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['password_reset_success'] = true;
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['password_reset_error'] = "Error resetting password.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
        }

        input[type="password"] {
            width: 20%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 20%;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Reset Password</h2>
    
    <?php
    if (isset($_SESSION['password_reset_error'])) {
        echo '<p style="color: red;">' . $_SESSION['password_reset_error'] . '</p>';
        unset($_SESSION['password_reset_error']);
    }
    ?>

    <form action="reset_password_form.php" method="post">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>