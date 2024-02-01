<?php
session_start();

if (isset($_SESSION["admin_username"])) {
    header("Location: admin-dashboard.php");
    exit();
}

function validate_login($username, $password, $pdo)
{
    $query = "SELECT * FROM feedbacks.admins WHERE username = ? AND password = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $password]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result !== false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_host = "localhost";
    $db_user = "admin";
    $db_password = "password";
    $db_name = "feedbacks";

    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST["username"];
        $password = $_POST["password"];

        if (validate_login($username, $password, $pdo)) {
            $_SESSION["admin_username"] = $username;
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
</body>

</html>