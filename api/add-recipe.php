<?php

require '../confg.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    $stmt = $conn->prepare('insert into recipes (user_id, name, ingredients, steps) values (?, ?, ?, ?)');
    $stmt->bind_param('isss',$user_id, $name, $ingredients, $steps);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'recipe inserted']);


} else {
    echo json_encode(['error' => 'wrong request method']);
}