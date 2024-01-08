<?php
session_start();
session_regenerate_id();
if(!isset($_SESSION['admin']))
{
    $myMessage = 'You are not logged in. Please log in.';
    header('Location: ../admin-login.php?message=' . $myMessage);
}
$id = $_SESSION['admin'];

include 'connect-pdo.php';

$admin_email = $_SESSION['admin'];
?>