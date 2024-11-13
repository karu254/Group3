<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $layer_feed_price = $_POST['layer_feed_price'];
    $chick_feed_price = $_POST['chick_feed_price'];

    // Prepare the SQL query with the new fields
    $sql = "INSERT INTO sales (date, item, quantity, unit_price, layer_feed_price, chick_feed_price) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiii", $date, $item, $quantity, $unit_price, $layer_feed_price, $chick_feed_price);

    // Execute the query and handle the response
    if ($stmt->execute()) {
        header("Location: sales.php"); // Redirect back to the form on successful entry
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Data Entry</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Sales Data Entry Form</h2>
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
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="item">Item:</label>
            <input type="text" id="item" name="item" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="unit_price">Unit Price (Ksh):</label>
            <input type="number" step="0.01" id="unit_price" name="unit_price" required>

            <label for="layer_feed_price">Layer Feed Price (Ksh):</label>
            <input type="number" step="0.01" id="layer_feed_price" name="layer_feed_price" required>

            <label for="chick_feed_price">Chick Feed Price (Ksh):</label>
            <input type="number" step="0.01" id="chick_feed_price" name="chick_feed_price" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
