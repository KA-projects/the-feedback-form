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
        $text = isset($_POST["text"]) ? trim($_POST["text"]) : null;
        $changedByAdmin = "yes";


        if (empty($email) || empty($text)) {
            $responseData = [
                'success' => false,
                'message' => 'Email ,text are required field.'
            ];
        } else {
            $stmt = $db->prepare("UPDATE $table SET text = :text , changedByAdmin = :changedByAdmin WHERE email = :email");

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':changedByAdmin', $changedByAdmin);


            $stmt->execute();


            $count = $stmt->rowCount();
            echo json_encode($count);
        }

    }
    //GET
    else if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $sql = "SELECT * FROM $table ORDER BY date DESC";
        $result = $db->query($sql);

        $data = array();

        while ($row = $result->fetch()) {
            $data[] = array(
                'name' => $row["name"],
                'email' => $row["email"],
                'text' => $row["text"],
                'date' => $row["date"],
                'status' => $row['status'],
                'changedByAdmin' => $row['changedByAdmin']
            );
        }

        echo json_encode($data);
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