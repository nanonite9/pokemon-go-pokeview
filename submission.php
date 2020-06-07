<?php

require_once "config/Twig.php";

session_start();

/**
 * Using Twig to render template
 * Parameters: logged_in - boolean specifying whether the user is logged in
 *
 * Unauthenticated users are redirected to the login page
 */
if(isset($_SESSION['username'])) {
    echo $twig->render('submission.html', array('logged_in' => isset($_SESSION['username'])));
} else {
    header('Location: login.php');
    exit();
}

