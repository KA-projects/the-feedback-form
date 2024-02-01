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
        $name = $_POST["name"];
        $email = $_POST["email"];
        $text = $_POST["text"];
        $date = $_POST["date"];

        if (!isset($name) || !isset($email) || !isset($text)) {
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

            $stmt = $db->prepare("INSERT INTO $table (name, email, text, date) VALUES (:name, :email, :text, :date)");

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':date', $date);

            $stmt->execute();


            $count = $stmt->rowCount();

            if ($count > 0) {
                $responseData = [
                    'success' => true,
                    'message' => 'Data added successfully',
                    'name' => $name,
                    'email' => $email,
                    'text' => $text,
                    'date' => $date
                ];
            } else {
                $responseData = [
                    'success' => false,
                    'message' => 'Failed to add data'
                ];
            }
        }

        echo json_encode($responseData);
    } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $sql = "SELECT * FROM $table";
        $result = $db->query($sql);

        $data = array();

        while ($row = $result->fetch()) {
            $data[] = array(
                'name' => $row["name"],
                'email' => $row["email"],
                'text' => $row["text"],
                'date' => $row["date"]
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