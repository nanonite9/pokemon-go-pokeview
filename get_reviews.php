<?php

require_once "persistence/ReviewRepository.php";

if(empty($_GET['id'])) {
    http_response_code(400);
    echo "'id' query parameter cannot be empty";
    exit();
}

$pokestopId = $_GET['id'];
$reviews = ReviewRepository::findReviewsWithUserByPokestop($pokestopId);

header("content-type:application/json");
echo json_encode($reviews, JSON_PRETTY_PRINT);
