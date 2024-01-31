<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $text = $_POST["text"];

    $response = [
        'status' => 'success',
        'message' => 'Data received successfully',
        'data' => [
            'name' => $name,
            'email' => $email,
            'text' => $text,
        ],
    ];

    echo json_encode($response);
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method',
    ];

    echo json_encode($response);
}

?>