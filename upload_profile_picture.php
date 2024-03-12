<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "finalproject";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
        // File upload handling
        $target_dir = __DIR__ . "/uploads/";
        $original_filename = basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $original_filename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            // If file exists, append a timestamp to the filename
            $timestamp = time();
            $new_filename = pathinfo($original_filename, PATHINFO_FILENAME) . "_$timestamp.$imageFileType";
            $target_file = $target_dir . $new_filename;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                // Update the user's profile picture in the database
                $relative_path = "uploads/" . basename($target_file);
                $update_sql = "UPDATE parent_child_details SET profile_picture = '$relative_path' WHERE user_id = $user_id";

                // Execute the SQL query
                if ($conn->query($update_sql) === TRUE) {
                    // Echo the new profile picture path
                    echo $relative_path;
                } else {
                    echo "Error updating profile picture: " . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Close the database connection
    $conn->close();
} else {
    echo "You are not logged in. Please log in to upload a profile picture.";
}
?>
