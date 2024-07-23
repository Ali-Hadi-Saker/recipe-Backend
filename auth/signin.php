<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require '../confg.php';

// Ensure that the Content-Type is set to JSON
header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decode the incoming JSON request
    $input = json_decode(file_get_contents('php://input'), true);

    // Log incoming data
    file_put_contents('php://stderr', print_r($input, TRUE));

    if (isset($input['username']) && isset($input['password'])) {
        $username = $input['username'];
        $pass = $input['password'];

        $stmt = $conn->prepare('SELECT id_user, password FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $hashedPass);
        $stmt->fetch();

        if ($stmt->num_rows == 0) {
            $response['status'] = 'error';
            $response['message'] = 'User not found';
        } else {
            if (password_verify($pass, $hashedPass)) {
                $payload = [
                    'iat' => time(),
                    'exp' => time() + 3600, // Token valid for 1 hour
                    'sub' => $user_id,
                    'role' => 'user'
                ];
                $jwt = JWT::encode($payload, 'en1iu2pebn1pi2b1o2n31@$?<1241@$1$1$!$!', 'HS256');
                $response['success'] = true;
                $response['message'] = 'User login successful';
                $response['jwt'] = $jwt;
            } else {
                $response['success'] = false;
                $response['message'] = 'Invalid password';
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
?>
