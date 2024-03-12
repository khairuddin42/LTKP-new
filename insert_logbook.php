<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Logbook Entry</title>
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
            border-radius: 8px;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .logbook-entry {
            background-color: #f9f9f9;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        button, a.button {
            padding: 12px 24px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            display: inline-block;
            text-decoration: none;
            margin-right: 10px; /* Adjust margin as needed */
        }

        button:hover, a.button:hover {
            background-color: #555;
        }

        .edit-mode {
            background-color: #FFFFE0;
        }

        footer {
            text-align: center;
            padding: 1em;
            background-color: #333;
            color: #fff;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <h2>Admin Logbook Entry</h2>
</header>

<main>  

    <form action="insert_logbook.php" method="post">
        <?php
        // Include your database connection script
        include 'database.php';

        // Fetch distinct user_ids from parent_child_details table
        $userIdsStmt = $pdo->query("SELECT DISTINCT user_id FROM parent_child_details");
        $userIds = $userIdsStmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- Hidden input field to store the selected user_id -->
        <input type="hidden" name="user_id" id="selected_user_id" value="<?php echo $userIds[0]['user_id']; ?>">

        <!-- Dropdown menu for user selection -->
        <label for="user_select">Select User:</label>
        <select name="user_select" id="user_select" onchange="updateSelectedUserId()">
            <?php
            foreach ($userIds as $userId) {
                $selected = $userId['user_id'] == $userIds[0]['user_id'] ? 'selected' : '';
                echo "<option value=\"{$userId['user_id']}\" $selected>{$userId['user_id']}</option>";
            }
            ?>
        </select>

        <!-- Logbook Entry Form -->
        <table border="1">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Activity</th>
                    <th>Learning</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="date" name="entry_date" required></td>
                    <td><input type="text" name="day" required></td>
                    <td><input type="text" name="activity" required></td>
                    <td><textarea name="learning" rows="4" required></textarea></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="Submit Logbook" class="button">
    </form>

    <?php
    // Insert new logbook entry
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entry_date'])) {
        $stmt = $pdo->prepare("INSERT INTO logbook (user_id, entry_date, day, activity, learning) VALUES (:user_id, :entry_date, :day, :activity, :learning)");
        $stmt->bindParam(':user_id', $_POST['user_id']);
        $stmt->bindParam(':entry_date', $_POST['entry_date']);
        $stmt->bindParam(':day', $_POST['day']);
        $stmt->bindParam(':activity', $_POST['activity']);
        $stmt->bindParam(':learning', $_POST['learning']);

        if ($stmt->execute()) {
            echo "Logbook entry saved successfully.";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }

    // Display logbook entries for the selected user
    $selectedUserId = $_POST['user_id'] ?? $userIds[0]['user_id'];
    $logbookStmt = $pdo->prepare("SELECT * FROM logbook WHERE user_id = :user_id");
    $logbookStmt->bindParam(':user_id', $selectedUserId);
    $logbookStmt->execute();
    $logbookEntries = $logbookStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($logbookEntries)) {
        echo "<main><h2>Logbook Entries</h2></mail>";
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Activity</th>
                        <th>Learning</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($logbookEntries as $entry) {
            echo "<tr class='logbook-entry'>
                    <td>{$entry['entry_date']}</td>
                    <td>{$entry['day']}</td>
                    <td>{$entry['activity']}</td>
                    <td>{$entry['learning']}</td>
                    <td>
                        <button class='edit-btn' onclick='editLogbookEntry(this, {$entry['id']})'>Edit</button>
                        <a href='delete_logbook.php?id={$entry['id']}' onclick='return confirm(\"Are you sure you want to delete this entry?\")'>Delete</a>
                    </td>
                </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "No logbook entries found for the selected user.";
    }
    ?>

    <script>
        function updateSelectedUserId() {
            var selectedUserId = document.getElementById('user_select').value;
            document.getElementById('selected_user_id').value = selectedUserId;
        }

        function editLogbookEntry(button, entryId) {
            var row = button.closest('.logbook-entry');
            var cells = row.getElementsByTagName('td');

            for (var i = 0; i < cells.length - 1; i++) {
                var input = document.createElement('input');
                input.type = 'text';
                input.value = cells[i].innerText;
                cells[i].innerHTML = '';
                cells[i].appendChild(input);
            }

            button.classList.add('edit-mode');
            button.innerText = 'Save';

            button.onclick = function () {
                var data = {
                    id: entryId,
                    entry_date: cells[0].querySelector('input').value,
                    day: cells[1].querySelector('input').value,
                    activity: cells[2].querySelector('input').value,
                    learning: cells[3].querySelector('input').value
                };

                // Send data to server for updating in the database
                fetch('update_logbook.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        button.classList.remove('edit-mode');
                        button.innerText = 'Edit';

                        for (var i = 0; i < cells.length - 1; i++) {
                            cells[i].innerText = data[Object.keys(data)[i]];
                        }
                    } else {
                        alert('Failed to update logbook entry.');
                    }
                });
            };
        }
    </script>
    <a href="dashboard.php"><button type="button">Back to admin dashboard</button></a>
<footer>
    &copy; <?php echo date('Y'); ?> Your Company Name
</footer>

</main>
</body>
</html>
