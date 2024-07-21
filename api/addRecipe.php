<?php

require '../confg.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    $stmt = $conn->prepare('insert into recipes (name, ingridients, steps) values (?, ?, ?)');
    $stmt->bind_param('sss', $name, $ingredients, $steps);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'recipe inserted']);


} else {
    echo json_encode(['error' => 'wrong request method']);
}