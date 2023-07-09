<?php

session_start();

function getUser()
{
    $loggedInUserid = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;

    if (!$loggedInUserid) {
        return null;
    }

    $usersFile = json_decode(file_get_contents('./database/users.json'), true);

    $users = $usersFile['users'];

    $foundUser = null;

    foreach ($users as $user) {
        if ($user['id'] === $loggedInUserid) {
            $foundUser = $user;
        }
    }

    return $foundUser;
}
