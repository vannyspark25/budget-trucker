<?php
session_start();

if (empty($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}
?>
