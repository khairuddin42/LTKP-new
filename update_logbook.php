<?php
// Include your database connection script
include 'database.php';

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Update logbook entry in the database
    $stmt = $pdo->prepare("UPDATE logbook SET entry_date = :entry_date, day = :day, activity = :activity, learning = :learning WHERE id = :id");
    $stmt->bindParam(':entry_date', $data['entry_date']);
    $stmt->bindParam(':day', $data['day']);
    $stmt->bindParam(':activity', $data['activity']);
    $stmt->bindParam(':learning', $data['learning']);
    $stmt->bindParam(':id', $data['id']);

    $result = ['success' => false];

    if ($stmt->execute()) {
        $result['success'] = true;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    // If the request is not a POST request, return an error response
    header('HTTP/1.1 400 Bad Request');
    echo 'Bad Request';
}
?>