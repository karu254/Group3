<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];
    $column = $_POST['column'];
    $value = $_POST['value'];
    $id = $_POST['id'];

    // Validate input
    if (empty($table) || empty($column) || empty($id)) {
        echo 'error';
        exit;
    }

    // Sanitize input
    $table = $conn->real_escape_string($table);
    $column = $conn->real_escape_string($column);
    $value = $conn->real_escape_string($value);
    $id = $conn->real_escape_string($id);

    // Prepare and execute update query
    $sql = "UPDATE `$table` SET `$column` = '$value' WHERE `id` = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error';
    }
}

$conn->close();
?>
