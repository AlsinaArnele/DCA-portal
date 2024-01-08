<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

include 'connect-pdo.php';

$email = $_POST['one'];
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$mail = new PHPMailer(true);

try {
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = uniqid();

        $sql = "INSERT INTO password_reset (user_email, token_value) VALUES (:email, :token)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $resetLink = 'https://portal.dotconnectafrica.org/reset.php?token=' . $token;

        // Mail function
        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'leviskibet2002@gmail.com';
            $mail->Password = 'ykns mnlz ypnl zrpv';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        
            $mail->setFrom('leviskibet2002@gmail.com', 'DCA ADMIN');
            $mail->addAddress($email, 'Recipient Name');
        
            $mail->isHTML(true); // Set email format to HTML for rich text formatting
            $mail->Subject = 'DCA Portal Password Reset';
            $mail->Body = 'Follow this link to reset your password: ' . $resetLink . '.';
            $mail->send();

            $myMessage = "Please check your email for Password reset link.";
            header("Location: ../index.php?response=" . urlencode($myMessage));
        } catch (Exception $e) {
            $myMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
            
    } else {
        $myMessage = "User not found.";
        header("Location: ../forgot.php?response=" . urlencode($myMessage));
        exit();
    }

    header("Location: ../index.php?response=" . urlencode($myMessage));
    exit();
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
