<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


$user = "admin";
$password = "password";
$database = "feedbacks";
$table = "feedbacks.feedbacks_list";

try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $text = $_POST["text"];
        $date = $_POST["date"];

        $stmt = $db->prepare("INSERT INTO $table (name, email, text, date) VALUES (:name, :email, :text, :date)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':date', $date);

        $stmt->execute();

        $count = $stmt->rowCount();

        echo json_encode($count);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid request method',
        ];
        echo json_encode($response);
    }
} catch (PDOException $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage(),
    ];
    echo json_encode($response);
}



?>