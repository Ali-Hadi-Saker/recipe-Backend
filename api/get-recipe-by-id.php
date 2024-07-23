<?php

require '../confg.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $id = $_GET['recipe_id'];

    $stmt = $conn->prepare('SELECT name, description, steps FROM recipes WHERE id_recipe = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());


}else{
    echo json_encode(['message' => 'wrong method']);
}