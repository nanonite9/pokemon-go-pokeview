<?php

require_once "persistence/PokestopRepository.php";
require_once "persistence/ReviewRepository.php";

getPokestops();

/**
 * Get pokestops based on either the pokestop name or review rating
 */
function getPokestops()
{
    if (!empty($_GET['placename'])) {
        $pokestops = PokestopRepository::findPokestopsByName($_GET['placename']);
    } elseif (!empty($_GET['rating'])) {
        if ($_GET['rating'] == "any") {
            $pokestops = PokestopRepository::findAllPokestops();
        } else {
            $pokestops = PokestopRepository::findPokestopsByReviewRating($_GET['rating']);
        }
    }

    header("content-type:application/json");
    echo json_encode($pokestops, JSON_PRETTY_PRINT);
}

