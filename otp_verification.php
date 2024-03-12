<?php
session_start();
require 'database.php';

// Ensure the reset_email session variable is set
if (!isset($_SESSION['reset_email'])) {
    $_SESSION['otp_verification_error'] = "Invalid email or OTP.";
    header("Location: login.php");
    exit();
}

$email = $_SESSION['reset_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOtp = $_POST['otp'];

    if (empty($enteredOtp)) {
        $_SESSION['otp_verification_error'] = "Invalid OTP.";
        header("Location: login.php");
        exit();
    }

    $query = "SELECT * FROM user_registration WHERE email = ? AND otp = ? AND otp_expiry > " . time();
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $email, $enteredOtp);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Valid OTP
            $_SESSION['valid_otp'] = true;
            // Redirect to the password reset form
            header("Location: reset_password_form.php");
            exit();
        } else {
            // Invalid OTP or OTP has expired
            $_SESSION['otp_verification_error'] = "Invalid OTP or OTP has expired.";
            header("Location: otp_verification.php");
            exit();
        }
    } else {
        // Handle the case where the query failed
        $_SESSION['otp_verification_error'] = "Query failed.";
        header("Location: otp_verification.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="otp.css">
</head>
<body>
    <h2>OTP Verification</h2>

    <?php
    // Check if there are any error messages to display
    if (isset($_SESSION['otp_verification_error'])) {
        echo '<p style="color: red;">' . $_SESSION['otp_verification_error'] . '</p>';
        unset($_SESSION['otp_verification_error']);
    }

    // Retrieve username and email from the user_registration table based on the email
    $query = "SELECT username, email FROM user_registration WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $email = $row['email'];
    } else {
        // Handle the case where the email is not found
        echo '<p style="color: red;">Email not found in the database.</p>';
        exit();
    }
    ?>

    <p>Username: <?php echo $username; ?></p>
    <p>Email: <?php echo $email; ?></p>

    <form action="otp_verification.php" method="post">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <br>
        <button type="submit">Verify OTP</button>
    </form>
</body>
</html>