<?php
        include 'connect-pdo.php';
        $sql = "SELECT * FROM password_reset WHERE token_value = :token ORDER BY id DESC LIMIT 1";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $user['user_email'];
            $timestamp = strtotime($user['time']); // Convert the timestamp from the database to a Unix timestamp
        
            // Check if the token is older than 24 hours
            if (time() - $timestamp > 86400) {
                $myMessage = "Token has expired. Please request a new password reset.";
                header("Location: ../forgot.php?response=" . urlencode($myMessage));
                exit();
            }

            $password = $_POST['confirm_password'];
            $token = $_POST['token'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql2 = "UPDATE users SET password = :password WHERE email = :email";
            $stmt2 = $dbh->prepare($sql2);
            $stmt2->bindParam(':password', $hashed_password);
            $stmt2->bindParam(':email', $email);
            $stmt2->execute();

            $myMessage = "Password reset successfully.";
            header("Location: ../index.php?response=" . urlencode($myMessage));
        } else {
            $myMessage = "Invalid token.";
            header("Location: ../forgot.php?response=" . urlencode($myMessage));
            exit();
        }
    ?>