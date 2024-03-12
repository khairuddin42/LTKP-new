<?php
session_start();
$showForm = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'database.php'; // File to connect to your database

    // Collect and sanitize input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate the input (you can add more validation as needed)
    if (empty($username) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.');</script>";
    } elseif (!preg_match("/[A-Za-z]/", $password) || !preg_match("/\d/", $password)) {
        echo "<script>alert('Password must contain at least one letter and one number.');</script>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database using prepared statement
        $query = "INSERT INTO user_registration (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            // Retrieve the user_id after registration
            $user_id = mysqli_insert_id($conn);

            // Set user_id in the session
            $_SESSION['user_id'] = $user_id;

            echo "User registered successfully.";
            $showForm = false; // Do not show the form if registration is successful

            // Redirect to parent_signup.php
            header("Location: parent_signup.php");
            exit();
        } else {
            echo "Error: Unable to register user. Please try again later.";
            // Log detailed error for yourself
            error_log("Error: " . $query . "\n" . mysqli_error($conn));
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}

if ($showForm) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <link rel="stylesheet" href="register.css">
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <!-- Replace with your logo path -->
                <img src="LTKP logo.jpg" alt="Little Thinkers Centre Logo">
            </div>
            <div class="form-container">
                <h2>Sign Up to LTKP</h2>
                <form action="register.php" method="post">
                    <div class="input-group">
                        <input type="text" id="username" name="username" required>
                        <label for="username">Username</label>
                    </div>

                    <div class="input-group">
                        <input type="email" id="email" name="email" required>
                        <label for="email">E-mail address</label>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="password" required>
                        <label for="password">Password</label>
                    </div>

                    <input type="submit" value="Register" class="submit-btn">
                </form>
                <div class="footer">
                    <p>Already have an account? <a href="login.php">Log in here</a></p>
                </div>
            </div>
        </div>
    </body>
    </html>
<?php
}
?>