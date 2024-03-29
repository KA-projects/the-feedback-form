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
        $name = isset($_POST["name"]) ? trim($_POST["name"]) : null;
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
        $text = isset($_POST["text"]) ? trim($_POST["text"]) : null;
        $date = isset($_POST["date"]) ? trim($_POST["date"]) : null;
        $status = "awaited";
        $changedByAdmin = "no";

        if (empty($name) || empty($email) || empty($text)) {
            $responseData = [
                'success' => false,
                'message' => 'Name, email, and text are required fields.'
            ];
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $responseData = [
                'success' => false,
                'message' => 'Invalid email address.'
            ];
        } else {
            $count = 0;

            //place to paste fake data
            $stmt = $db->prepare("INSERT INTO $table (name, email, text, date, status, changedByAdmin) VALUES (:name, :email, :text, :date, :status, :changedByAdmin)");

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':changedByAdmin', $changedByAdmin);

            $stmt->execute();


            $count = $stmt->rowCount();

            if ($count > 0) {
                $responseData = [
                    'success' => true,
                    'message' => 'Data added successfully',
                    'name' => $name,
                    'email' => $email,
                    'text' => $text,
                    'date' => $date,
                    'status' => $status,
                    'changedByAdmin' => $changedByAdmin
                ];
            } else {
                $responseData = [
                    'success' => false,
                    'message' => 'Failed to add data'
                ];
            }
        }

        echo json_encode($responseData);
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