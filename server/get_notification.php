<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('connection.php'); // Ensure this points to your correct configuration file

// Check the database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT message FROM notifications ORDER BY timestamp DESC";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Error executing query: " . $conn->error);
}

$messages = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messages[] = $row['message'];
    }
}

echo implode("\n", $messages);

// Close the database connection
$conn->close();
?>
