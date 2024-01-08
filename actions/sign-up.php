<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

include 'connect-pdo.php'; 
try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $username = strtolower($_POST['Username']);
    $email = strtolower($_POST['Email']);
    $password = $_POST['Password'];
    $confirm_password = $_POST['confirm-password'];
    $creation_date = date('Y-m-d');
    $status = 'verify';
    $default_value = 1;
    $default_value1 = 0;
    $mail = new PHPMailer(true);
    $stm = $dbh->prepare('SELECT * FROM users WHERE email = :email');
    $stm->bindParam(':email', $email);
    $stm->execute();
    if($stm->rowCount() > 0){
        $myMessage = "Email already registered!";
        header("Location: ../signup.php?response=" . urlencode($myMessage));
        exit();
    }
    else{
        if ($password !== $confirm_password) {
            $myMessage = "Passwords do not match!";
            header("Location: ../signup.php?response=" . urlencode($myMessage));
            exit();
        }
        else{ 
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $dbh->prepare("INSERT INTO users (username, email, creation_date, `password`, `status`  ) VALUES (:username, :email, :creation_date, :password, :status )");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':creation_date', $creation_date);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            $_SESSION['email'] = $email;
            $token = rand( 100000 , 999999);
            $stmt2 = $dbh->prepare("INSERT INTO `tokens` (`user_email`, `token_value`) VALUES (:email, :token)");
            $stmt2->bindParam(':email', $_POST['Email']);
            $stmt2->bindParam(':token', $token);
            $stmt3 = $dbh->prepare("INSERT INTO `services` (`user_email`) VALUES (:email)");
            $stmt3->bindParam(':email', $_POST['Email']);
            $stmt3->execute();
            if ($stmt2->execute()) {
                // EMAIL THE USER
                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to DEBUG_SERVER for detailed debug output
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Specify your SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'leviskibet2002@gmail.com'; // Your SMTP username
                    $mail->Password = 'ykns mnlz ypnl zrpv'; // Your SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                
                    //Recipients
                    $mail->setFrom('leviskibet2002@gmail.com', 'DCA ADMIN');
                    $mail->addAddress($_POST['Email'], 'Recipient Name'); // Add a recipient
                
                    //Content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = 'DCA Portal Verification';
                    $mail->Body = 'Your verification code is ' . $token . '.';
                
                    $mail->send();
                    $myMessage = "Registration successful. Please check your email for verification.";
                    header("Location: ../signup.php?response=" . urlencode($myMessage));
                } catch (Exception $e) {
                    $myMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                
            } 
            else {
                $myMessage = "Registration failed.";
                header("Location: ../signup.php?response=" . urlencode($myMessage));
                exit();
            }
        } 
    }
} catch (PDOException $e) {
     die("Connection failed: " . $e->getMessage());
}
?>