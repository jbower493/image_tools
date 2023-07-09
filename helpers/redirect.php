<?php

function redirect($url)
{
    header('Location: ' . $url, true, 301);
    exit();
}
