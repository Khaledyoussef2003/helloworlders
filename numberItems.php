<?php 
// session_start();
$user_id = $_SESSION['user-id'];

require_once 'connection.php';
$sql = "SELECT count(id) FROM card WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['count(id)'];
?>