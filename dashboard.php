<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1> Admin Dashboard</h1>
</header>

<main>
    <p>Welcome to admin dashboard section. Here, you can manage LTKP data information for users.</p>

    <!-- Additional content or instructions can be added here -->

    <div>
    <h1>Admin Dashboard</h1>
    <p><a href="tuition_details.php"><button type="button">Manage Tuition Details</button></a></p>
    <p><a href="admin_comments.php"><button type="button">View Admin Comments</button></a></p>
    <p><a href="insert_logbook.php"><button type="button">Edit Logbook</button></a></p>

    <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </div>
</main>

<footer>
    &copy; <?php echo date('Y'); ?> Little Thinker Kota Puteri
</footer>

</body>
</html>