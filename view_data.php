<?php
include 'config.php';

// Fetch data from the tables
$tables = ['chicks_data', 'egg_production', 'feed_consumption', 'layers_data', 'sales'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Edit Data</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>View and Edit Data</h2>
<!-- Navigation Section -->
<nav>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="dashboard.php">Dashboard & Reports</a></li>
                <li><a href="chicks_data.php">Chicks Data Entry</a></li>
                <li><a href="egg_production.php">Egg Production Entry</a></li>
                <li><a href="feed_consumption.php">Feed Consumption Entry</a></li>
                <li><a href="layers_data.php">Layers Data Entry</a></li>
                <li><a href="sales.php">Sales Data Entry</a></li>
                <li><a href="view_data.php">View & Edit Data</a></li>
            </ul>
        </nav>
        <?php foreach ($tables as $table): ?>
            <h3><?php echo ucfirst(str_replace('_', ' ', $table)); ?></h3>
            <table border="1">
                <thead>
                    <tr>
                        <?php
                        // Get column names
                        $result = $conn->query("SHOW COLUMNS FROM $table");
                        $columns = [];
                        while ($row = $result->fetch_assoc()) {
                            $columns[] = $row['Field'];
                            echo "<th>{$row['Field']}</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch data
                    $result = $conn->query("SELECT * FROM $table");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-table='$table' data-id='{$row['id']}'>";
                        foreach ($columns as $column) {
                            echo "<td contenteditable='true' data-column='$column'>{$row[$column]}</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endforeach; ?>

        <button id="updateAllButton">Update All Changes</button>
    </div>

    <script>
        // Object to track changes
        const changes = {};

        // Detect changes in contenteditable cells
        $('td[contenteditable=true]').on('input', function() {
            const td = $(this);
            const newValue = td.text();
            const column = td.data('column');
            const id = td.closest('tr').data('id');
            const table = td.closest('tr').data('table');

            // Initialize table changes if not present
            if (!changes[table]) {
                changes[table] = {};
            }

            // Initialize row changes if not present
            if (!changes[table][id]) {
                changes[table][id] = {};
            }

            // Store the changed value
            changes[table][id][column] = newValue;
        });

        // Function to handle "Update All" button click
        $('#updateAllButton').on('click', function() {
            if ($.isEmptyObject(changes)) {
                alert('No changes to update.');
                return;
            }

            // Send AJAX request to update data
            $.ajax({
                url: 'batch_update.php',
                method: 'POST',
                data: { changes: JSON.stringify(changes) },
                success: function(response) {
                    if (response === 'success') {
                        alert('Data updated successfully.');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to update data: ' + response);
                    }
                },
                error: function() {
                    alert('Error occurred while updating data.');
                }
            });
        });
    </script>
</body>
</html>
