<?php
// db_connect.php

$host = 'localhost';
$dbname = 'grading_tool';
$user = 'root';
$password = ''; // Update password if necessary

//  User and password can be updated to "csc350" and "xampp" but I've left them as root and blank for now.

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
