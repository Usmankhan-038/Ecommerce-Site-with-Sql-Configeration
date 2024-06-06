<?php
include('connection.php');
session_start();
$user_id = $_SESSION['user_id'];
$notification_id = $_POST['notification_id'];

$sql = "INSERT INTO user_notification (notification_id, user_id, product_id, status)
        VALUES (:notification_id, :user_id, 0, true)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'notification_id' => $notification_id,
    'user_id' => $user_id
]);

echo "Notification marked as seen";
?>
