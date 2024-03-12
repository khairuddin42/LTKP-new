<?php
session_start();

require 'database.php';
require 'vendor/autoload.php'; // Include PHPMailer library

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function generateOTP() {
    // Generate a random 6-digit OTP
    return strval(mt_rand(100000, 999999));
}

function sendOTPEmail($recipientEmail, $otp) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to DEBUG_SERVER for debugging
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'm.khairuddin0309@gmail.com'; // Replace with your SMTP username
        $mail->Password = 'adlf rhrp xzhn bymp'; // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use PHPMailer::ENCRYPTION_SMTPS for SSL
        $mail->Port = 587; // Adjust the port if necessary

        // Recipients
        $mail->setFrom('m.khairuddin0309@gmail.com', 'LTKP Reset Password');
        $mail->addAddress($recipientEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset OTP';
        $mail->Body = 'Your OTP for password reset: ' . $otp;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log or display the error
        error_log("Email sending error: " . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $_SESSION['reset_error'] = "Invalid email address.";
        header("Location: login.php");
        exit();
    }

    $query = "SELECT * FROM user_registration WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $otp = generateOTP();
        $otpExpiry = time() + 300; // OTP is valid for 5 minutes

        // Store the OTP and expiry time in the database
        $updateQuery = "UPDATE user_registration SET otp = ?, otp_expiry = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'sss', $otp, $otpExpiry, $email);
        mysqli_stmt_execute($stmt);

        // Send an OTP email
        if (sendOTPEmail($email, $otp)) {
            $_SESSION['reset_email'] = $email;
            header("Location: otp_verification.php");
            exit();
        } else {
            $_SESSION['reset_error'] = "Error sending OTP email.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['reset_error'] = "Email address not found.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset Request</title>
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
            width: 100%;
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
            width: 10%;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Password Reset Request</h2>
    
    <?php
    if (isset($_SESSION['reset_error'])) {
        echo '<p style="color: red;">' . $_SESSION['reset_error'] . '</p>';
        unset($_SESSION['reset_error']);
    }
    ?>
<main>
    <form action="reset_request.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit">Submit</button>
    </form>
</main>
</body>
</html>
