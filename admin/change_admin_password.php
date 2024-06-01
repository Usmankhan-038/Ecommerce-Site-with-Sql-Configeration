<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Retrieve form data
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Fetch current password from the database
$stmt = $conn->prepare("SELECT admin_password FROM admin WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($admin_password);
$stmt->fetch();
$stmt->close();

// Check if the current password matches the one stored in the database
if ($current_password=== $admin_password) {
    // Check if the new password and confirm password match
    if ($new_password === $confirm_password) {
        // Hash the new password
        
        // Update the password in the database
        $stmt = $conn->prepare("UPDATE admin SET admin_password = ? WHERE admin_id = ?");
        $stmt->bind_param("si", $new_password, $admin_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Password changed successfully.";
        } else {
            $_SESSION['message'] = "Failed to change password.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "New passwords do not match.";
    }
} else {
    $_SESSION['message'] = "Current password is incorrect.";
}

// Redirect back to the admin account page
header('Location: admin_account.php');
exit();
?>
