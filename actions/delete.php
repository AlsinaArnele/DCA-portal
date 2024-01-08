<?php
include 'connect.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();

    $stmnt3 = $conn->prepare("DELETE FROM services WHERE user_email = ?");
    $stmnt3->bind_param("s", $email);
    $stmnt3->execute();
    $stmnt3->close();

    $stmnt4 = $conn->prepare("DELETE FROM sessions WHERE user_email = ?");
    $stmnt4->bind_param("s", $email);
    $stmnt4->execute();
    $stmnt4->close();
    
}
header("Location: ../users.php");
exit();

$conn->close();
?>
