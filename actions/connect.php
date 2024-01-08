<?php 
    $servername = 'localhost';
    // $username = 'root';
    // $password = '';
    $username = 'wariditesting';
    $password = '_5LG^;*im4T1';
    $dbname = 'dca-portal';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 ?>