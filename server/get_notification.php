<?php
include('connection.php');
session_start();
$user_id = $_SESSION['user_id'];

$sql = "SELECT n.notification_id, n.message
        FROM notification n
        LEFT JOIN user_notification un ON n.notification_id = un.notification_id AND un.user_id = :user_id
        WHERE un.user_id IS NULL";

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($notifications as $notification) {
    echo $notification['notification_id'] . '::' . $notification['message'] . "\n";
}
?>
