<?php

require_once "config/Twig.php";

session_start();

/**
 * Using Twig to render template
 * Parameters: logged_in - boolean specifying whether the user is logged in
 */
echo $twig->render('about.html', array('logged_in' => isset($_SESSION['username'])));
