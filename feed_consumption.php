<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $layer_feed = $_POST['layer_feed'];
    $chick_feed = $_POST['chick_feed'];

    $sql = "INSERT INTO feed_consumption (date, layer_feed, chick_feed) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdd", $date, $layer_feed, $chick_feed);

    if ($stmt->execute()) {
        header("Location: feed_consumption.php");
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
    <title>Feed Consumption Data Entry</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <div class="container">
        <h2>Feed Consumption Data Entry Form</h2>
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
            <label>Date:</label>
            <input type="date" name="date" required>
            <label>Layer Feed (kg):</label>
            <input type="number" step="0.01" name="layer_feed" required>
            <label>Chick Feed (kg):</label>
            <input type="number" step="0.01" name="chick_feed" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
