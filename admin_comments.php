<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Comments</title>
    <link rel="stylesheet" href="admin.css">
    <style>

    </style>
</head>
<body>

<header>
    <h1>Admin Comments</h1>
</header>

<main>
    <?php
    // Include the database connection code
    include('database.php');

    // Fetch comments from the database
    $sql = "SELECT * FROM user_comments";
    $result = $conn->query($sql);

    // Display comments
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display comment details
            echo "<div class='comment-container'>";
            echo "<p><strong>User ID:</strong> " . $row['user_id'] . "</p>";
            echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
            echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
            echo "<p><strong>Subject:</strong> " . $row['subject'] . "</p>";
            echo "<p><strong>Message:</strong> " . $row['message'] . "</p>";
            echo "<p><strong>Timestamp:</strong> " . $row['timestamp'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments found.</p>";
    }

    // Close the result set
    $result->close();
    ?>

    <a href="dashboard.php"><button type="submit">Back to admin dashboard</button></a>
</main>

<footer>
    &copy; <?php echo date('Y'); ?> Your Company Name
</footer>

</body>
</html>