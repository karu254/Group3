<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poultry Farm Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Poultry Farm Dashboard</h2>

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

        <!-- Feed Consumption Trend -->
        <div class="chart-container">
            <h3>Feed Consumption Trend</h3>
            <canvas id="feedConsumptionChart"></canvas>
        </div>

        <!-- Egg Production Analysis -->
        <div class="chart-container">
            <h3>Egg Production Analysis</h3>
            <canvas id="eggProductionChart"></canvas>
        </div>

        <!-- Layers Data Overview -->
        <div class="chart-container">
            <h3>Layers Data Overview</h3>
            <canvas id="layersDataChart"></canvas>
        </div>

        <!-- Sales Performance -->
        <div class="chart-container">
            <h3>Sales Performance</h3>
            <canvas id="salesChart"></canvas>
        </div>

        <!-- Sales vs Feed Cost Comparison -->
        <div class="chart-container">
            <h3>Daily Sales vs Feed Cost Comparison</h3>
            <canvas id="salesFeedComparisonChart"></canvas>
        </div>
    </div>

    <script>
        // Feed Consumption Trend
        const feedConsumptionData = {
            labels: [],
            layerFeed: [],
            chickFeed: []
        };

        <?php
        $result = $conn->query("SELECT date, layer_feed, chick_feed FROM feed_consumption");
        while ($row = $result->fetch_assoc()) {
            echo "feedConsumptionData.labels.push('{$row['date']}');";
            echo "feedConsumptionData.layerFeed.push({$row['layer_feed']});";
            echo "feedConsumptionData.chickFeed.push({$row['chick_feed']});";
        }
        ?>

        new Chart(document.getElementById('feedConsumptionChart'), {
            type: 'line',
            data: {
                labels: feedConsumptionData.labels,
                datasets: [
                    {
                        label: 'Layer Feed (kg)',
                        data: feedConsumptionData.layerFeed,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Chick Feed (kg)',
                        data: feedConsumptionData.chickFeed,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: { responsive: true }
        });

        // Egg Production Analysis
        const eggProductionData = {
            labels: [],
            totalEggs: [],
            spoiledEggs: []
        };

        <?php
        $result = $conn->query("SELECT date, total_eggs, spoiled_eggs FROM egg_production");
        while ($row = $result->fetch_assoc()) {
            echo "eggProductionData.labels.push('{$row['date']}');";
            echo "eggProductionData.totalEggs.push({$row['total_eggs']});";
            echo "eggProductionData.spoiledEggs.push({$row['spoiled_eggs']});";
        }
        ?>

        new Chart(document.getElementById('eggProductionChart'), {
            type: 'bar',
            data: {
                labels: eggProductionData.labels,
                datasets: [
                    {
                        label: 'Total Eggs',
                        data: eggProductionData.totalEggs,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    },
                    {
                        label: 'Spoiled Eggs',
                        data: eggProductionData.spoiledEggs,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)'
                    }
                ]
            },
            options: { responsive: true }
        });

        // Layers Data Overview
        const layersData = { totalEggs: 0, spoiledEggs: 0 };

        <?php
        $result = $conn->query("SELECT SUM(total_eggs) as total_eggs, SUM(spoiled_eggs) as spoiled_eggs FROM layers_data");
        $row = $result->fetch_assoc();
        echo "layersData.totalEggs = {$row['total_eggs']};";
        echo "layersData.spoiledEggs = {$row['spoiled_eggs']};";
        ?>

        new Chart(document.getElementById('layersDataChart'), {
            type: 'pie',
            data: {
                labels: ['Total Eggs', 'Spoiled Eggs'],
                datasets: [{
                    data: [layersData.totalEggs, layersData.spoiledEggs],
                    backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)']
                }]
            },
            options: { responsive: true }
        });

        // Sales Performance
        const salesData = {
            labels: [],
            totalSales: []
        };

        <?php
        $result = $conn->query("SELECT date, SUM(total_price) as total_sales FROM sales GROUP BY date");
        while ($row = $result->fetch_assoc()) {
            echo "salesData.labels.push('{$row['date']}');";
            echo "salesData.totalSales.push({$row['total_sales']});";
        }
        ?>

        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: salesData.labels,
                datasets: [{
                    label: 'Total Sales (Ksh)',
                    data: salesData.totalSales,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)'
                }]
            },
            options: { responsive: true }
        });

        // Sales vs Feed Cost Comparison
        const feedCostData = [];

        <?php
        $result = $conn->query("SELECT date, SUM(total_price) as total_sales, AVG(layer_feed_price) as layer_feed_price, AVG(chick_feed_price) as chick_feed_price FROM sales GROUP BY date");
        $feedResult = $conn->query("SELECT date, SUM(layer_feed) as total_layer_feed, SUM(chick_feed) as total_chick_feed FROM feed_consumption GROUP BY date");

        $feedData = [];
        while ($feedRow = $feedResult->fetch_assoc()) {
            $feedData[$feedRow['date']] = [
                'total_layer_feed' => $feedRow['total_layer_feed'],
                'total_chick_feed' => $feedRow['total_chick_feed']
            ];
        }

        while ($row = $result->fetch_assoc()) {
            $date = $row['date'];
            $totalSales = $row['total_sales'];
            $layerFeedPrice = $row['layer_feed_price'];
            $chickFeedPrice = $row['chick_feed_price'];
            $totalLayerFeed = $feedData[$date]['total_layer_feed'] ?? 0;
            $totalChickFeed = $feedData[$date]['total_chick_feed'] ?? 0;
            $totalFeedCost = ($totalLayerFeed * $layerFeedPrice) + ($totalChickFeed * $chickFeedPrice);

            echo "salesData.labels.push('{$date}');";
            echo "feedCostData.push({$totalFeedCost});";
        }
        ?>

        new Chart(document.getElementById('salesFeedComparisonChart'), {
            type: 'line',
            data: {
                labels: salesData.labels,
                datasets: [
                    {
                        label: 'Total Sales (Ksh)',
                        data: salesData.totalSales,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Total Feed Cost (Ksh)',
                        data: feedCostData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>
