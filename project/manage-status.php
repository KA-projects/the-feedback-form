<?php
header('Content-Type: application/json');

$user = "admin";
$password = "password";
$database = "feedbacks";
$table = "feedbacks.feedbacks_list";

try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);

    //POST 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
        $status = isset($_POST["status"]) ? trim($_POST["status"]) : null;

        if (empty($email) || empty($status)) {
            $responseData = [
                'success' => false,
                'message' => 'Email ,status are required.'
            ];
        } else {
            $stmt = $db->prepare("UPDATE $table SET status = :status WHERE email = :email");

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':status', $status);

            $stmt->execute();

            $count = $stmt->rowCount();

            if ($count > 0) {
                $responseData = [
                    'success' => true,
                    'message' => 'Status changed successfully',
                    'email' => $email,
                    'status' => $status,
                ];
            } else {
                $responseData = [
                    'success' => false,
                    'message' => 'Failed to changed status'
                ];
            }

            echo json_encode($responseData);
        }

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