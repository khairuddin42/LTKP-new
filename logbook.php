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
    <a href="about.php" class="nav-link">About</a>
    <a href="howitworks.php" class="nav-link">How it works</a>
    <a href="fee.php" class="nav-link">Fee</a>
    <a href="Contacts.php" class="nav-link">Contacts</a>
    <a href="profile.php" class="nav-link">👤</a>
    
</nav>
</header> <!-- End of Navbar -->

<?php
// Include your database connection script
include 'database.php';

// Start the session
session_start();

// Get the user_id from the session, default to 0 if not set
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Define the number of entries to display per page
$entriesPerPage = 5;

// Calculate the total number of entries for the specified user
$sqlTotalEntries = "SELECT COUNT(*) as total FROM logbook WHERE user_id = :user_id";
$stmtTotalEntries = $pdo->prepare($sqlTotalEntries);
$stmtTotalEntries->bindParam(':user_id', $user_id);
$stmtTotalEntries->execute();
$totalEntries = $stmtTotalEntries->fetchColumn();

// Calculate the total number of pages
$totalPages = ceil($totalEntries / $entriesPerPage);

// Get the current page number from the query string, default to page 1
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the starting index for retrieving entries from the database
$startIndex = ($currentPage - 1) * $entriesPerPage;

// Retrieve logbook data for the current page and user from the database
$sql = "SELECT * FROM logbook WHERE user_id = :user_id LIMIT :startIndex, :entriesPerPage";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
$stmt->bindParam(':entriesPerPage', $entriesPerPage, PDO::PARAM_INT);
$stmt->execute();
$logbookData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logbook Entries</title>
    <link rel="stylesheet" href="logbook.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Logbook Entries - Week <?php echo $currentPage; ?></h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Activity</th>
                <th>Learning</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logbookData as $entry) : ?>
                <tr>
                    <td><?php echo $entry['entry_date']; ?></td>
                    <td><?php echo $entry['day']; ?></td>
                    <td><?php echo $entry['activity']; ?></td>
                    <td><?php echo $entry['learning']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="logbook.php?page=<?php echo $i; ?>"><?php echo "Week $i"; ?></a>
        <?php endfor; ?>
    </div>
    <form action="profile.php" method="post">
        <input type="submit" value="Back">
    </form>
</body>
</html>
