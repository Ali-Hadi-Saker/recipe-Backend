<?php

require '../confg.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $recipe = isset($_GET['name'])? $_GET['name'] : '';

    if(!$recipe){
        $stmt = $conn->prepare('select * from recipes');
    }else{
        $stmt = $conn->prepare('select * from recipes where name=?');
        $stmt->bind_param('s', $recipe);
    }    
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