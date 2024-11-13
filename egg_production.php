<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $total_eggs = $_POST['total_eggs'];
    $spoiled_eggs = $_POST['spoiled_eggs'];
    $quantity = $_POST['quantity'];
    $spoiled = $_POST['spoiled'];

    $sql = "INSERT INTO egg_production (date, total_eggs, spoiled_eggs, quantity, spoiled) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $date, $total_eggs, $spoiled_eggs, $quantity, $spoiled);

    if ($stmt->execute()) {
        header("Location: egg_production.php");
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
    <title>Egg Production Data Entry</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Egg Production Data Entry Form</h2>
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
            <label>Total Eggs:</label>
            <input type="number" name="total_eggs" required>
            <label>Spoiled Eggs:</label>
            <input type="number" name="spoiled_eggs" required>
            <label>Quantity:</label>
            <input type="number" name="quantity" required>
            <label>Spoiled:</label>
            <input type="number" name="spoiled" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
