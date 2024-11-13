<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $changes = json_decode($_POST['changes'], true);

    if (empty($changes)) {
        echo 'error';
        exit;
    }

    foreach ($changes as $table => $rows) {
        foreach ($rows as $id => $columns) {
            // Construct SET part of the update query
            $setParts = [];
            foreach ($columns as $column => $value) {
                $safeColumn = $conn->real_escape_string($column);
                $safeValue = $conn->real_escape_string($value);
                $setParts[] = "`$safeColumn` = '$safeValue'";
            }
            $setQuery = implode(', ', $setParts);

            // Update query
            $sql = "UPDATE `$table` SET $setQuery WHERE `id` = '$id'";
            if (!$conn->query($sql)) {
                echo 'error: ' . $conn->error;
                exit;
            }
        }
    }

    echo 'success';
}

$conn->close();
?>
