<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $_POST['index'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($tasks[$index])) {
        $task_id = $tasks[$index]['id'];
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $task_id);
        $stmt->execute();
    }

    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
}
?>
