<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
   include 'connect.php';

    $id = $_POST['id'];

    $sql = "SELECT status FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    $stmt->fetch();
    $stmt->close();

    $newStatus = ($currentStatus === "active") ? "disabled" : "active";

    $updateSql = "UPDATE users SET status = ? WHERE email = ?";

    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $newStatus, $id);
    $updateStmt->execute();
    $updateStmt->close();

    $conn->close();
    header('Location: ../users.php');
}
?>