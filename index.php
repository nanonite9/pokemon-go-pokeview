<?php

require_once "config/Twig.php";

session_start();

/**
 * Using Twig to render template
 * Parameters: logged_in - boolean specifying whether the user has logged in
 *             username - username retrieved from session
 */
if (isset($_SESSION['username'])) {
    echo $twig->render('index.html', array('logged_in' => isset($_SESSION['username']), 'username' => $_SESSION['username']));
} else {
    echo $twig->render('index.html', array('logged_in' => isset($_SESSION['username'])));
}

?>