<?php

require_once 'persistence/PokestopRepository.php';
require_once 'persistence/ReviewRepository.php';
require_once 'config/Twig.php';
require_once 'config/Constants.php';

session_start();

/**
 * Find pokestops in the database based on place name or review rating
 * Use Twig to render template
 * Parameters: logged_in - boolean specifying whether the user is logged in
 *             pokestops - PDO associative array of pokestops
 *             resultsText - Title for the page
 *             googleMapApiKey - Google Map API Key
 */
$placename = $_GET['placename'];
$rating = $_GET['rating'];

echo $twig->render('search_results.html', array('logged_in' => isset($_SESSION['username']),
    'pokestops' => getPokestops($placename, $rating), 'resultsText' => getResultsText($placename, $rating), 'googleMapApiKey' => GOOGLE_MAPS_API_KEY));


/**
 * Get pokestops from the database
 *
 * @param $placename
 * @param $rating
 * @return associative array
 */
function getPokestops($placename, $rating)
{
    if (!empty($placename)) {
        return PokestopRepository::findPokestopsByName($placename);
    } elseif (!empty($rating)) {
        if ($rating == "any") {
            return PokestopRepository::findAllPokestops();
        } else {
            return PokestopRepository::findPokestopsByReviewRating($rating);
        }
    }
}

/**
 * Get search results text
 *
 * @param $placename
 * @param $rating
 * @return string
 */
function getResultsText($placename, $rating)
{
    if (!empty($placename)) {
        return "Search results for Place Name '" . $placename . "'";
    } elseif (!empty($_GET['rating'])) {
        return "Search results for Rating '" . $rating . "'";
    } else {
        return "Search parameters not specified!";
    }
}