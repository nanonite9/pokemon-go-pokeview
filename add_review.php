<?php

require_once 'persistence/ReviewRepository.php';

session_start();

/*
 * Check if user is authenticated
 */
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit();
}

validateData();
saveReview();

function saveReview()
{
    $rating = $_POST['rating'];
    $review = $_POST['review_message'];
    $pokestop_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $review_id = ReviewRepository::save($user_id, $pokestop_id, $review, $rating);

    $savedReview = ReviewRepository::findReviewById($review_id);

    echo json_encode($savedReview);
}

function validateData() {
    if (!isset($_POST['rating']) || empty($_POST['rating'])) {
        http_response_code(400);
        echo "'rating' field required";
        exit();
    } elseif (!isset($_POST['review_message']) || empty($_POST['review_message'])) {
        http_response_code(400);
        echo "'review_message' field required";
        exit();
    }  elseif (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo "'id' query parameter cannot be empty";
        exit();
    }
}