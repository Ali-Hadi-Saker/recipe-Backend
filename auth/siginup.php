<?php


require '../confg.php';

if($_SERVER['METHOD_REQUEST'] == 'POST'){

    $name = $_POST('name');
    $username = $_POST('username');
    $email = $_POST('email');
    $pass = $_POST('password');


    $check = $conn->prepare('select * from users where username=? or email=?');
    $check->bind_param('ss', $username, $email);
    $check->execute();
    $result = $check->get_result();
    if($result->num_rows > 0){
        echo json_encode(['error' => 'user alrady exist']);

    } else {
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('insert into users (name, username, email, password) value (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $username, $email, $hashed_pass);
        $stmt->execute();
        $response['status'] = 'success';
        $response['message'] = 'inserted successfully';
        
        echo json_encode($response);
    }
} else {
    echo json_encode(['error' => 'wrong method']);
}