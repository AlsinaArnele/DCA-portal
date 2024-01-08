<?php
include 'connect.php';
session_start();
session_regenerate_id();
if(!isset($_SESSION['user']))
{
    header("Location:login.php");
}
$id = $_SESSION['user'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result( $user_id,$image_path, $user_username, $email, $phone, $password, $creation_date, $status); // Bind the result columns to variables
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<script>
    function checkStatus() {
    const element = document.getElementById("user-data"); 
            const status = element.innerText.toLowerCase().trim();

            if (status === 'disabled') {
                element.style.color = 'red';
            } else if (status === 'active') {
                element.style.color = 'green';
            }
    }

    checkStatus();
</script>