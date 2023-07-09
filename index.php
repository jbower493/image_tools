<?php

require_once './helpers/session.php';
require_once './helpers/redirect.php';

$user = getUser();

if (!$user) {
    redirect('/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="assets/css/main.css" type="text/css" rel="stylesheet">
    <title>Image Tools</title>
</head>

<body>
    <form class="imageForm" action="/image.php" method="POST" enctype="multipart/form-data">
        <div class="formField">
            <label for="image">File To Process</label>
            <input type="file" id="image" name="image">
        </div>
        <div class="formField">
            <label for="transformation">Select An Action</label>
            <select id="transformation" name="transformation">
                <option value="removeBg">Remove Background</option>
                <option value="memeGen">Generate Meme</option>
            </select>
        </div>
        <div class="memeTextContainer memeTextContainer--hidden">
            <div class="formField formField--memeText">
                <label for="lineOne">Text line one</label>
                <input type="text" id="lineOne" name="lineOne">
            </div>
            <div class="formField formField--memeText">
                <label for="lineOne">Text line two</label>
                <input type="text" id="lineTwo" name="lineTwo">
            </div>
        </div>

        <div class="formField">
            <button>Process Image</button>
        </div>
        <a href="/logout.php">Logout</a>
    </form>

    <script src="./assets/js/main.js"></script>
</body>

</html>