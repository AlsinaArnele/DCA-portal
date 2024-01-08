<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST["Username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $user_password = $_POST["password"];
    session_start();
    session_regenerate_id(); 
    if(!isset($_SESSION['admin']))
    {
       header("Location:../admin-login.php");
    }
    $admin_username = $_SESSION['admin']; 
 
    include 'connect.php';
    $sql = "UPDATE admin SET username=?, email=?, password=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT); 
    $stmt->bind_param("ssss", $admin_name, $email, $hashed_password, $admin_username);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: ../admin-profile.php");
    exit(); 
}
?>
