<?php
// Include your database connection script
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $entryId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare and execute the DELETE query
    $stmt = $pdo->prepare("DELETE FROM logbook WHERE id = :id");
    $stmt->bindParam(':id', $entryId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Logbook entry deleted successfully.";
        echo '<br><br><a href="insert_logbook.php">Back to Logbook Entry</a>';
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
        echo '<br><br><a href="insert_logbook.php">Back to Logbook Entry</a>';
    }
} else {
    echo "Invalid request.";
    echo '<br><br><a href="insert_logbook.php">Back to Logbook Entry</a>';
}
?>