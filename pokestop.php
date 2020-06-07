<?php

require_once "persistence/PokestopRepository.php";
require_once "persistence/ReviewRepository.php";
require_once "config/Twig.php";
require_once 'config/Constants.php';

session_start();

/**
 * Load pokestop from the database
 * Use Twig to render template
 * Parameters: logged_in - boolean specifying whether the user is logged in
 *             pokestop - PDO associative array
 *             googleMapApiKey - Google Map API Key
 */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo "'id' query parameter cannot be empty";
    exit();
} else {
    $pokestop = PokestopRepository::findPokestop($_GET['id']);
    echo $twig->render('pokestop.html', array('pokestop' => $pokestop, 'googleMapApiKey' => GOOGLE_MAPS_API_KEY, 'logged_in' => isset($_SESSION['username'])));
}

