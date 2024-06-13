<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-Do List</title>
  <link rel="stylesheet" href="public/styles.css">
</head>
<body>
  <h1>To-Do List</h1>
  <input type="text" id="taskInput" placeholder="Enter a task">
  <button onclick="addTask()">Add Task</button>
  <ul id="taskList"></ul>

  <script src="public/script.js"></script>
</body>
</html>
