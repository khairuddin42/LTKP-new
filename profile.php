<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Little Thinkers KOTA Puteri</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="navbar">
  <div class="navbar-brand">
    <img src="LTKP.png" alt="Little Thinkers Kota Puteri" class="logo"> <!-- Replace with your logo -->
    <a href="#" class="brand-name">Little Thinkers Kota Puteri</a>
  </div>
  <nav class="navbar-nav">
    <a href="homepage.php" class="nav-link">Home</a>
    <a href="about1.php" class="nav-link">About</a>
    <a href="howitworks1.php" class="nav-link">How it works</a>
    <a href="fee1.php" class="nav-link">Fee</a>
    <a href="Contacts1.php" class="nav-link">Contacts</a>
    <a href="profile.php" class="nav-link">👤</a>
    
</nav>
</header> <!-- End of Navbar -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<div class="container">
    <h1>User Profile</h1>

    <div class="profile-info">
        <?php
        // Start the session
        session_start();

        // Check if the user is logged in by verifying the session variable
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Establish a connection to the database (you can reuse your database connection code)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "finalproject";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve user profile data based on the user's ID
            $sql = "SELECT * FROM parent_child_details WHERE user_id = $user_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $parent_name = $row['parent_name'];
                $parent_address = $row['parent_address'];
                $parent_phone = $row['parent_phone'];
                $parent_email = $row['parent_email'];
                $child_name = $row['child_name'];
                $child_gender = $row['child_gender'];
                $child_age = $row['child_age'];
                $parent_age = $row['parent_age'];
                $baby_type = $row['baby_type'];

                // Display user profile data
                echo '<img src="' . (isset($row['profile_picture']) ? $row['profile_picture'] . '?timestamp=' . time() : 'default_profile.jpg') . '" alt="Profile Picture" class="profile-picture" id="profile-picture">';
                echo "<div class='details'>";
                echo "<p><strong>Parent Name:</strong> $parent_name</p>";
                echo "<p><strong>Parent Address:</strong> $parent_address</p>";
                echo "<p><strong>Phone Number:</strong> $parent_phone</p>";
                echo "<p><strong>Email:</strong> $parent_email</p>";
                echo "<p><strong>Child Name:</strong> $child_name</p>";
                echo "<p><strong>Child Gender:</strong> $child_gender</p>";
                echo "<p><strong>Child Age:</strong> $child_age</p>";
                echo "<p><strong>Parent Age:</strong> $parent_age</p>";
                echo "<p><strong>Baby Type:</strong> $baby_type</p>";
                echo "</div>";
            } else {
                echo "User profile not found.";
            }

            // Close the database connection
            $conn->close();
        } else {
            // Redirect the user to the login page or display a message if not logged in
            echo "You are not logged in. Please <a href='login.php'>log in</a> to view your profile.";
        }
        
        
        ?>
        
    </div>

    <form id="upload-form" enctype="multipart/form-data">
        <!-- Add a hidden input field to store the user ID -->
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

        <label for="profile_picture">Change Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*" id="file-input">
        <input type="button" value="Upload" id="upload-button">
    </form>

    <form action="logout.php" method="post">
        <button type="submit" class="logout-btn">Logout</button>
    </form>

    <!-- JavaScript to handle the AJAX upload -->
    <script>
        $(document).ready(function () {
            $('#upload-button').on('click', function () {
                var formData = new FormData($('#upload-form')[0]);

                $.ajax({
                    url: 'upload_profile_picture.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // Update the profile picture instantly
                        $('#profile-picture').attr('src', data);
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            });
        });
    </script>
</div>

</body>
</html>



    <!-- Tuition Fee -->
    <?php
    // Database credentials
    $host = 'localhost';
    $db = 'finalproject';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    // Set up DSN
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Create a PDO instance (connect to the database)
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    // Fetch the current status for each month for the logged-in user
    $stmt = $pdo->prepare("SELECT January, February, March, April, May, June, July, August, September, October, November, December FROM tuition_detail WHERE user_id = :user_id ORDER BY tuition_id");
$stmt->execute([':user_id' => $user_id]);
$statuses = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2>Tuition Fee</h2>

<form action="" method="post">
    <table class="month-table">
        <tr>
            <?php
            // Check if $statuses is an array before using it in a foreach loop
            if (is_array($statuses)) {
                foreach ($statuses as $month => $paidStatus): ?>
                    <td>
                        <label class="month-label">
                            <?php echo $month; ?>
                            <input type="checkbox" disabled <?php echo $paidStatus ? 'checked' : ''; ?>>
                        </label>
                    </td>
                <?php endforeach;
            } else {
                echo "<td colspan='12'>No data available</td>";
            }
            ?>
        </tr>
    </table>

    <a href="logbook.php" class="logbook-btn-link">
        <button type="button" class="logbook-btn">Logbook</button>
    </a>
</form>
</body>
</html>

