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
    <style>
        .changedByAdmin {
            display: block;
            color: #008BFF;
        }

        .notChangedByAdmin {
            display: none;
        }
    </style>
</head>

<body>
    <h2>Welcome,
        <?php echo $_SESSION["admin_username"]; ?>!
    </h2>
    <p>This is the admin dashboard.</p>
    <form id="editFeedback">
        <p id="editedEmail"></p>
        <textarea name="text" cols="30" rows="10"></textarea>
        <button type="submit">Confirm</button>
    </form>
    <ul id="feedbacksListForAdmin"></ul>
    <a href="logout.php">Logout</a>

    <script src="js/admin.js"></script>
</body>

</html>