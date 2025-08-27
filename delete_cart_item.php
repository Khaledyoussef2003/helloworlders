<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user-id'])) {
    header("location:login.php");
    exit;
}

if (isset($_GET['id'])) {
    $card_id = (int)$_GET['id'];
    $user_id = $_SESSION['user-id'];
    
    $stmt = $conn->prepare("DELETE FROM card WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $card_id, $user_id);
    $stmt->execute();
}

header("Location: shopping2.php");
?>
