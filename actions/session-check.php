<?php
session_start();
if (!isset($_SESSION['user'])) {
    $mymessage = "You are not logged in.";
    header("Location: index.php?message={$mymessage}");
    exit();
}
$id = $_SESSION['user'];
include 'connect.php';

$sql = "SELECT username, id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($user_name, $user_id);

if ($stmt->fetch()) {
} else {
    echo "No records found.";
}

$stmt->close();
$conn->close();
?>
