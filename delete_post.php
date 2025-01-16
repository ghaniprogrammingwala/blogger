<?php
require_once 'config.php';
session_start();

if(!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false]);
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
