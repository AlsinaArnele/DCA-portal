<?php
include 'connect.php';
include 'session-check.php';

$password = $_POST['confirm_password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmnt = $conn->prepare("UPDATE users SET Password = ? WHERE Email = ?");
$stmnt->bind_param("ss", $hashedPassword, $id);
$stmnt->execute();
$stmnt->close();

$stmnt2 = $conn->prepare("DELETE FROM password_reset WHERE user_email = ?");
$stmnt2->bind_param("s", $id);
$stmnt2->execute();
$stmnt2->close();

header("Location: ../index.php?response=Password reset successful. Please login.");

?>