<?php

require '../confg.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $username = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare('select id_user, password from users where username=?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashedPass );
    $stmt->fetch();

    $user = $stmt->num_rows;
     if($user == 0){
        $response['message'] = 'user not found';

     }else{
        if(password_verify($pass, $hashedPass)){
            $response['status'] = 'authenticated';
            $response['message'] = 'Logged in';

        } else {
            $response['message'] = 'wrong password';
        }
     }
     echo json_encode($response);
    


}else {
    echo json_encode(['error' => 'wrong method']);
}