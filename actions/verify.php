<?php
session_start();
include 'connect-pdo.php';

$code = $_POST['one'];
$email = $_SESSION['email'];

try {
    $stmt = $dbh->prepare("SELECT * FROM tokens WHERE token_value = :token AND user_email = :email");
    $stmt->bindParam(':token', $code);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $stmt2 = $dbh->prepare("UPDATE users SET status = 'active' WHERE email = :email");
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();

        $stmt3 = $dbh->prepare("DELETE FROM tokens WHERE user_email = :email");
        $stmt3->bindParam(':email', $email);
        $stmt3->execute();

        $myMessage = "Email address verified successfully.";
        header("Location: ../index.php?response=" . urlencode($myMessage));
        unset($_SESSION['email']);
    } else {
        $myMessage = "Invalid verification code.";
        header("Location: ../verify.php?response=" . urlencode($myMessage));
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
