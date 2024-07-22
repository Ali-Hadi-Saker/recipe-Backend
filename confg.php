<?php
header("Access-Control-Allow-Origin: *");  // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = '';
$db_name = 'recipe_db';

$conn = new mysqli($servername, $username, $password, $db_name);

if($conn->connect_error ){
    die('Connection faild' . $conn->connect_error);
}

return $conn;