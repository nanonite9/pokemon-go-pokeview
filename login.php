<?php

require_once "config/Twig.php";

session_start();

/**
 * Redirect user to the index.php if user is already logged
 * Using Twig to render template
 */
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
} else {
    echo $twig->render('login.html');
}

