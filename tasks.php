<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tasks);
?>
