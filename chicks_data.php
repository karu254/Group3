<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_number = $_POST['group_number'];
    $hatch_date = $_POST['hatch_date'];
    $feed_consumed = $_POST['feed_consumed'];

    $sql = "INSERT INTO chicks_data (group_number, hatch_date, feed_consumed) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isd", $group_number, $hatch_date, $feed_consumed);

    if ($stmt->execute()) {
        header("Location: chicks_data.php");
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
    <title>Chicks Data Entry</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Chicks Data Entry Form</h2>
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
            <label>Hatch Date:</label>
            <input type="date" name="hatch_date" required>
            <label>Feed Consumed (kg):</label>
            <input type="number" step="0.01" name="feed_consumed" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
