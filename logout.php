<?php

require_once './helpers/session.php';
require_once './helpers/redirect.php';

unset($_SESSION['userId']);
redirect('/login.php');
