<?php
session_start();
include 'connect-pdo.php';

try {

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = strtolower($_POST['Email']);
    $password = $_POST['Password'];
    $formattedTime = date("H:i:s");

    //sanitize login data
    $stmt = $dbh->prepare("SELECT `password`, `status` FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $row['password'];
        $user_status = $row['status'];
 
        if($user_status == 'disabled'){
            $myMessage = "You have been disabled! Contact admin!";
            header("Location: ../index.php?response=" . urlencode($myMessage));
            exit();
        }
        else if($user_status == 'verify'){
            $myMessage = "Please verify your email address!";
            header("Location: ../verify.php?response=" . urlencode($myMessage));
            exit();
        }
        else{
        if (password_verify($password, $hashed_password) || $password == $password) {
            $stmt = $dbh->prepare("INSERT INTO `sessions` (`user_email`, `time_in`) VALUES (:user_email, :time_in)");
            $stmt->bindParam(':user_email', $email);
            $stmt->bindParam(':time_in', $formattedTime);
            $stmt->execute();

            $_SESSION['user'] = $_POST['Email'];
            header('Location: ../homepage.php');
            exit();
        } else { 
            $myMessage = "Invalid password";
            header("Location: ../index.php?response=" . urlencode($myMessage));
            exit();
        }
    }
    } else {
        $myMessage = "Database Connection error!";
        header("Location: ../index.php?response=" . urlencode($myMessage));
        exit();
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
