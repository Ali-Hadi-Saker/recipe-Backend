<?php

require '../confg.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];
    $recipe_id = $_POST['recipe_id'];

    $stmt = $conn->prepare('insert into comments (user_id, recipe_id, comment) values (?, ?, ?)');
    $stmt->bind_param('iis', $user_id, $recipe_id, $comment);
    $stmt->execute();

    echo json_encode(['message' => 'comment added successfully']);

}else{
    echo json_encode(['message' => 'wrong method']);
}