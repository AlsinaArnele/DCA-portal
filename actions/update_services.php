<?php
include 'connect.php'; 

$newslack = $_POST['var1'];
$newleads = $_POST['var2'];
$newhosting = $_POST['var3'];
$newtrust = $_POST['var5'];
$newservices = $_POST['var6'];
$email = $_POST['var7'];

$sql = "UPDATE services SET slack = ?, leads = ?, hosting = ?, trust = ?, services = ? WHERE user_email = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("iiiiis", $newslack, $newleads, $newhosting, $newtrust, $newservices, $email);

if ($stmt->execute()) {
    $response = "Success: Services modified successfully.";
    echo json_encode($response);
} else {
    $response = "Error: Could not update the Database.";
    echo json_encode($response);
}

$conn->close();
?>
