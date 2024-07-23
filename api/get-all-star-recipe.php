<?php

require '../confg.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $stmt = $conn->prepare('select * from stars join recipes on recipes.id_recipe = stars.recipe_id');
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
        echo json_encode(['message' => 'No recipe exist']);

    }else{
        $recipes = [];
        while($row = $result->fetch_assoc()){
            $recipes[] = $row;
        }
        echo json_encode($recipes);

    }

}else{
    echo json_encode(['message' => 'wrong method']);
}