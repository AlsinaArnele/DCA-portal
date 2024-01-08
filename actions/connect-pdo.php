<?php 
$host = 'localhost';    
$dbname = 'dca-portal'; 
// $username = 'root';
// $password = '';
$username = 'wariditesting';
$password = '_5LG^;*im4T1'; 

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

