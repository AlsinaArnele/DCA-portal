<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user'])) {
    header("Location:../index.php");
    exit;
}
$id = $_SESSION['user'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $targetDirectory = 'uploads/';
    $targetFile = $targetDirectory . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        $myMessage = "Please upload a valid image file.";
        header("Location: ../edit-account.php?response=" . urlencode($myMessage));
        exit;
    }
    if (file_exists($targetFile)) {
        $myMessage = "Image file already exists!";
        header("Location: ../edit-account.php?response=" . urlencode($myMessage));
        exit;
    }
    if ($_FILES['image']['size'] > 10000000) {
        $myMessage = "File size is too large! Maximum file size is 10MB.";
        header("Location: ../edit-account.php?response=" . urlencode($myMessage));
        exit;
    }
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        $myMessage = "Please upload an image file of type JPG, JPEG, PNG or GIF.";
        header("Location: ../edit-account.php?response=" . urlencode($myMessage));
        exit;
    }
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $image_path = $targetFile;
        $myMessage = "Image upload successful!";
        header("Location: ../edit-account.php?response=" . urlencode($myMessage));
    } else {
        $myMessage = "Unable to upload image. Please try again.";
        header("Location: ../edit-account.php?response=" . urlencode($myMessage));
        exit;
    }
}else if(!isset($_FILES["image"])){
    $myMessage = "Please select an image to upload.";
    header("Location: ../edit-account.php?response=" . urlencode($myMessage));
    exit;
}
if (!empty($image_path)) {
    include 'connect.php';

    // Retrieve the current image path from the database
    $selectSql = "SELECT image_url FROM users WHERE email = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("s", $id);
    $selectStmt->execute();
    $selectStmt->bind_result($currentImagePath);
    $selectStmt->fetch();
    $selectStmt->close();

    // Delete the current image file
    if (!empty($currentImagePath) && file_exists($currentImagePath)) {
        unlink($currentImagePath);
    }

    // Update the new image path in the database
    $updateSql = "UPDATE users SET image_url = ? WHERE email = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $image_path, $id);

    if ($updateStmt->execute()) {
        header("Location: ../edit-account.php");
        exit;
    } else {
        echo "Error: Unable to store the image path in the database.";
        header("Location: ../edit-account.php");
        exit;
    }

    $updateStmt->close();
    $conn->close();
} 

?>