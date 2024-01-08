<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_username = $_POST["Username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $user_password = $_POST["password"];
    session_start();
    session_regenerate_id(); 
    if(!isset($_SESSION['user']))
    {
       header("Location:index.php");
    }
    $id = $_SESSION['user']; 
 
    include 'connect.php';
    $sql = "UPDATE users SET username=?, email=?, phone=?, password=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT); 
    $stmt->bind_param("sssss", $user_username, $email, $phone, $hashed_password, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    $myMessage = "Updated successfully!";
    header("Location: ../edit-account.php?response=" . urlencode($myMessage));
    exit();
}
?>
