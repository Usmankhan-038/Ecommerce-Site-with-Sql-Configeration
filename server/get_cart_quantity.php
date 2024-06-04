<?php
session_start();

if (isset($_SESSION['quantity'])) {
    echo $_SESSION['quantity'];
} else {
    echo '0';
}
?>
