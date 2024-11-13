<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_number = $_POST['group_number'];
    $age_in_weeks = $_POST['age_in_weeks'];
    $total_eggs = $_POST['total_eggs'];
    $spoiled_eggs = $_POST['spoiled_eggs'];
    $date = $_POST['date'];

    $sql = "INSERT INTO layers_data (group_number, age_in_weeks, total_eggs, spoiled_eggs, date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiss", $group_number, $age_in_weeks, $total_eggs, $spoiled_eggs, $date);

    if ($stmt->execute()) {
        header("Location: layers_data.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layers Data Entry</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <div class="container">
        <h2>Layers Data Entry Form</h2>

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
        <form method="POST" action="">
            <label>Group Number:</label>
            <input type="number" name="group_number" required>
            <label>Age in Weeks:</label>
            <input type="number" name="age_in_weeks" required>
            <label>Total Eggs:</label>
            <input type="number" name="total_eggs" required>
            <label>Spoiled Eggs:</label>
            <input type="number" name="spoiled_eggs" required>
            <label>Date:</label>
            <input type="date" name="date" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
