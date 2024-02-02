<?php
session_start();

if (!isset($_SESSION["admin_username"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/admin.css">

</head>

<body>
    <div class="container">
        <h2>Welcome,
            <?php echo $_SESSION["admin_username"]; ?>!
        </h2>
        <p>This is the admin dashboard.</p>

        <a href="feedbacks.php">Back to feedbacks page</a>
        <a href="logout.php">Logout</a>

        <form id="editFeedback">
            <p id="editedEmail"></p>
            <textarea name="text" cols="30" rows="10"></textarea>
            <button type="submit">Confirm the change</button>
        </form>
        <ul id="feedbacksListForAdmin">

        </ul>

        <script src="js/admin.js"></script>
    </div>
</body>

</html>