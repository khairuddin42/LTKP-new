<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Signup</title>
    <link rel="stylesheet" href="parent_signup.css">
    
    <script>
        function validateForm() {
            var phoneNumber = document.forms["signupForm"]["parent_phone"].value;
            var email = document.forms["signupForm"]["parent_email"].value;
            var phoneRegex = /^\d{10}$/; // Simple regex for 10-digit phone number
            var emailRegex = /^\S+@\S+\.\S+$/; // Basic email regex

            if (!phoneRegex.test(phoneNumber)) {
                alert("Please enter a valid 10-digit phone number.");
                return false;
            }

            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true;
        }
    </script>  
</head>
<body>
    <h2>Parent Signup</h2>
    
    <?php
    // Check if user_id is set in the URL parameters
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
    ?>

    <form name="signupForm" action="signup_process.php" method="post" onsubmit="return validateForm()">
        <!-- Add a hidden input field to pass user_id to signup_process.php -->
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

        <label for="parent_name">Parent Name:</label>
        <input type="text" name="parent_name" required><br>

        <label for="parent_address">Parent Address:</label>
        <input type="text" name="parent_address" required><br>

        <label for="parent_phone">Phone Number:</label>
        <input type="tel" name="parent_phone" required><br>

        <label for="parent_email">Email:</label>
        <input type="email" name="parent_email" required><br>

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
            <option value="oku">OKU</option>
            <option value="asma">Asma</option>
            <option value="normal">Normal</option>
        </select><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>