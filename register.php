<?php

require_once './helpers/session.php';
require_once './helpers/redirect.php';

$user = getUser();

if ($user) {
    redirect('/');
}

$attemptedRegister = null;

function register()
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $usersFile = json_decode(file_get_contents('./database/users.json'), true);

    $users = $usersFile['users'];

    $foundUser = null;

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $foundUser = $user;
        }
    }

    if ($foundUser) {
        return [
            "success" => false,
            "error" => "User already exists with that email."
        ];
    }

    if ($confirmPassword !== $password) {
        return [
            "success" => false,
            "error" => "Passwords do not match",
        ];
    }

    $newUser = [
        "id" => $users[count($users) - 1]['id'] + 1,
        "email" => $email,
        "password" => $password
    ];

    array_push($usersFile['users'], $newUser);

    file_put_contents('./database/users.json', json_encode($usersFile));

    return [
        "success" => true,
        "error" => null
    ];
}

// If the user just tried to login, attempt to log them in
if ($_POST) {
    $attemptedRegister = register();

    if ($attemptedRegister['success']) {
        redirect('/login.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/main.css" type="text/css" rel="stylesheet">
    <title>Image Tools</title>
</head>

<body>
    <?php
    if ($attemptedRegister && !$attemptedRegister['success']) :
        echo '<div>' . $attemptedRegister['error'] . '</div>';
    endif
    ?>
    <form class="authForm" action="/register.php" method="POST">
        <div class="formField">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="formField">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="formField">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <div class="formField">
            <button>Register</button>
        </div>
        <a href="/login.php">Login</a>
    </form>
</body>

</html>