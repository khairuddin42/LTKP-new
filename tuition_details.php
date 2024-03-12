<?php
// Start the session
session_start();

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

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();

    try {
        // Retrieve selected user_id from the form
        $userId = $_POST['user_id'];

        // Update session data if needed
        $_SESSION['user_id'] = $userId;

        // Check if a row exists for the selected user in the tuition_detail table
        $checkStmt = $pdo->prepare("SELECT COUNT(*) as count FROM tuition_detail WHERE user_id = :user_id");
        $checkStmt->execute([':user_id' => $userId]);
        $rowCount = $checkStmt->fetchColumn();

        if ($rowCount == 0) {
            // If no row exists, insert a new row for the user
            $insertStmt = $pdo->prepare("INSERT INTO tuition_detail (user_id) VALUES (:user_id)");
            $insertStmt->execute([':user_id' => $userId]);
        }

        // Set all months to unpaid first for the selected user
        $stmt = $pdo->prepare("UPDATE tuition_detail SET January = 0, February = 0, March = 0, April = 0, May = 0, June = 0, July = 0, August = 0, September = 0, October = 0, November = 0, December = 0 WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);

        // Now update the paid status for the checked months for the selected user
        if (isset($_POST['months']) && is_array($_POST['months'])) {
            foreach ($_POST['months'] as $month => $paidStatus) {
                if ($paidStatus === 'on') {
                    $stmt = $pdo->prepare("UPDATE tuition_detail SET $month = 1 WHERE user_id = :user_id");
                    $stmt->execute([':user_id' => $userId]);
                }
            }
        }

        $pdo->commit();
        echo "Status updated successfully";

        // Debugging: Echo the updated session user_id
        echo "<p>Updated user_id in session: " . $_SESSION['user_id'] . "</p>";
    } catch (\PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}

// Fetch the current status for each month for the selected user
$userId = isset($_POST['user_id']) ? $_POST['user_id'] : (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);
$stmt = $pdo->prepare("SELECT January, February, March, April, May, June, July, August, September, October, November, December FROM tuition_detail WHERE user_id = :user_id");
$stmt->execute([':user_id' => $userId]);
$statuses = $stmt->fetch();

// Check if the query returned any results
if ($statuses === false) {
    $statuses = []; // Set an empty array if no results are found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <form action="" method="post">
        <label for="user_id">Select User:</label>
        <select name="user_id" id="user_id">
            <?php
            // Fetch user_ids from parent_child_details table
            $userIdsStmt = $pdo->query("SELECT DISTINCT user_id FROM parent_child_details");
            $userIds = $userIdsStmt->fetchAll();
            foreach ($userIds as $user) {
                $selected = ($user['user_id'] == $userId) ? 'selected' : '';
                echo "<option value=\"{$user['user_id']}\" $selected>{$user['user_id']}</option>";
            }
            ?>
        </select>
        <table class="month-table">
            <tr>
                <?php foreach ($statuses as $month => $paidStatus) : ?>
                    <td>
                        <label class="month-label" for="month-<?php echo $month; ?>">
                            <span class="month-name"><?php echo $month; ?></span>
                            <div class="checkbox-container">
                                <input type="checkbox" name="months[<?php echo $month; ?>]" id="month-<?php echo $month; ?>" <?php echo $paidStatus ? 'checked' : ''; ?>>
                                <div class="checkmark"></div>
                            </div>
                        </label>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>


        <br>
        <input type="submit" value="Update Status">
    </form>

    <p><a href="profile.php">Go to User Profile</a></p>
    <a href="dashboard.php"><button type="submit">Admin Dashboard</button></a>
    <footer>
        &copy; <?php echo date('Y'); ?> Your Company Name
    </footer>
</body>

</html>