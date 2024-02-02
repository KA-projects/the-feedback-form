<!DOCTYPE html>
<html>

<head>
    <title>Feedback Form</title>
    <link rel="stylesheet" type="text/css" href="css/feedbacks.css">

    <script src="js/jquery-3.7.1.min.js"></script>
</head>

<body>
    <header>
        <div>
            <a href="login.php">Login for admin</a>
        </div>
    </header>

    <div class="container">
        <div>
            Sort by
            <button id="sortByName">Name</button>
            <button id="sortByEmail">Email</button>
            <button id="sortByDate">Date</button>
        </div>

        <ul id="feedbackList">

        </ul>

        <form id="feedbackForm">
            <label for="name">Name</label>
            <input id="name" type="text" />

            <label for="email">Email</label>
            <input id="email" type="text" />

            <label for="text">Feedback</label>
            <textarea id="text" cols="30" rows="10"></textarea>

            <button type="submit">Preview of feedback</button>
        </form>
    </div>

    <script src="js/handleForm.js"></script>
</body>

</html>