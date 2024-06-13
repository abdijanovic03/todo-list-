<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    // Decode JSON string to PHP associative array
    $data = json_decode($json, true);

    $description = $data['task'];
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO tasks (description, user_id) VALUES (:description, :user_id)");
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($tasks);
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
