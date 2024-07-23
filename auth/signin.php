<?php

require '../confg.php';

// Ensure that the Content-Type is set to JSON
header('Content-Type: application/json');

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Decode the incoming JSON request
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['username']) && isset($input['password'])) {
        $username = $input['username'];
        $pass = $input['password'];

        $stmt = $conn->prepare('SELECT id_user, password FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $hashedPass);
        $stmt->fetch();

        $user = $stmt->num_rows;
        if($user == 0){
            $response['status'] = 'error';
            $response['message'] = 'User not found';
        } else {
            if(password_verify($pass, $hashedPass)){
                session_start();
                $_SESSION['user_id'] = $id;
                $response['status'] = 'authenticated';
                $response['message'] = 'Logged in';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Wrong password';
            }
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid input';
    }

} else {
    $response['status'] = 'error';
    $response['message'] = 'Wrong method';
}

echo json_encode($response);
