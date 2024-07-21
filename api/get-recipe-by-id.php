<?php

require '../confg.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $recipe_id = $_GET['recipe_id'];

    $stmt = $conn->prepare('select * from recipes where id_recipe=?');
    $stmt->bind_param('i', $recipe_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){
        // $result->fetch_assoc();
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode(['message' => 'No recipe exist']);
    }

}else{
    echo json_encode(['message' => 'wrong method']);
}