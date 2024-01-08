<?php
session_start();
include 'connect-pdo.php';

try {

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = strtolower($_POST['Username']);
    $password = $_POST['Password'];

    $stmt = $dbh->prepare("SELECT password FROM admin WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) { 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin_password = $row['password']; 

        if ($password == $admin_password || password_verify($password, $admin_password)) { 
            $_SESSION['admin'] = $username;
            header('Location: ../users.php');
            exit();
        } else {
            $myMessage = 'Incorrect password.';
            header('Location: ../admin-login.php?message=' . $myMessage);
            exit();
        }
    } else {
        $myMessage = 'Username does not exist.';
        header('Location: ../admin-login.php?message=' . $myMessage);
        exit();
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
} 
?>
