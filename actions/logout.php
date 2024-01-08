<?php
    session_start();

    include 'connect.php';
    $timeout = date("H:i:s");
    $id = $_SESSION['user'];

    $updateSql = "UPDATE `sessions` SET `time_out` = ? WHERE user_email = ? AND time_out = '00:00:00.000000'";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $timeout, $id);
    $updateStmt->execute();
    $updateStmt->close();

    unset($_SESSION['user']);
    $mymessage = "You have been logged out";
    header("Location: ../index.php?response=$mymessage");  
?>

 