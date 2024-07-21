<?php

require '../confg.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $recipe_id = $_GET['name'];

    $stmt = $conn->prepare('select * from recipes where name=?');
    $stmt->bind_param('s', $recipe_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $recipe = [];
        while ($row = $result->fetch_assoc()){
            $recipe[] = $row;
        }
        echo json_encode($recipe);
    }else{
        echo json_encode(['message' => 'No recipe exist']);
    }

}else{
    echo json_encode(['message' => 'wrong method']);
}