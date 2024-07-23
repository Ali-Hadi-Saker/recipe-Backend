<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../confg.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Parse JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Extract data from parsed JSON
    $name = $input['name'];
    $username = $input['username'];
    $email = $input['email'];
    $pass = $input['password'];

    // Check if user already exists
    $check = $conn->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $check->bind_param('ss', $username, $email);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['error' => 'user already exists']);
    } else {
        // Insert new user
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $username, $email, $hashed_pass);
        $stmt->execute();
        $response['status'] = 'success';
        $response['message'] = 'inserted successfully';
        
        echo json_encode($response);
    }

    // Close statements
    $stmt->close();
    $check->close();
} else {
    echo json_encode(['error' => 'wrong method']);
}

$conn->close();
