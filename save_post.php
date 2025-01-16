<?php
require_once 'config.php';
session_start();

if(!isset($_SESSION['user_id']) || !isset($_POST['title']) || !isset($_POST['content'])) {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $_POST['title'], $_POST['content']]);
    header('Location: dashboard.php');
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
