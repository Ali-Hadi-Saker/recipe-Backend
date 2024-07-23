<?php

require '../confg.php';

session_start();

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $user_id = $_SESSION['user_id'];
    $recipe_id = $_GET['recipe_id'];

    $stmt = $conn->prepare('insert into stars (user_id, recipe_id) values (?, ?)');
    $stmt->bind_param('ii', $user_id, $recipe_id);
    $stmt->execute();

    echo json_encode(['message' => 'star added successfully', 'status'=>'success']);

}else{
    echo json_encode(['error' => 'wrong method']);
}