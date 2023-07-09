<?php

require_once './helpers/session.php';
require_once './helpers/redirect.php';

$user = getUser();

if ($user) {
    redirect('/');
}

$attemptedLogin = null;

function login()
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usersFile = json_decode(file_get_contents('./database/users.json'), true);

    $users = $usersFile['users'];

    $foundUser = null;

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $foundUser = $user;
        }
    }

    if (!$foundUser) {
        return [
            "success" => false,
            "error" => "No user exists with that email.",
            "userId" => null
        ];
    }

    if ($foundUser['password'] !== $password) {
        return [
            "success" => false,
            "error" => "Incorrect password",
            "userId" => null
        ];
    }

    return [
        "success" => true,
        "error" => null,
        "userId" => $foundUser['id']
    ];
}

// If the user just tried to login, attempt to log them in
if ($_POST) {
    $attemptedLogin = login();

    if ($attemptedLogin['success']) {
        $_SESSION['userId'] = $attemptedLogin['userId'];

        redirect('/');
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
    <form class="authForm" action="/login.php" method="POST">
        <?php if ($attemptedLogin && !$attemptedLogin['success']) : ?>
            <div class="authForm__error"><?php echo $attemptedLogin['error'] ?></div>
        <?php endif; ?>
        <div class="authForm__container">
            <div class="formField">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="formField">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="formField">
                <button>Login</button>
            </div>
            <a href="/register.php">Register</a>
        </div>
    </form>
</body>

</html>