<?php
$host = 'localhost';
$db = 'hospital_managemant';
$user = 'root';
$password = ''; // Sesuaikan jika ada password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
