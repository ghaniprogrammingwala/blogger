<?php
$host = 'localhost';
$dbname = 'dbmocy0yvyrkon';
$username = 'u1j5hu8arjzak';
$password = 'kxyrgs6izs1y';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
