<?php

require_once 'persistence/PokestopRepository.php';
require_once 'config/S3Client.php';

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
savePokestop();

/**
 * Save pokestop in database and store pokestop image in Amazon S3
 * Using database transaction to rollback if/when the S3 image storage functionality fails
 */
function savePokestop()
{
    try {
        DB::getConnection()->beginTransaction(); // Start database transaction

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $s3FileKey = uniqid() . "." . $ext;

        $pokestop_id = createPokestopInDatabase($s3FileKey);
        S3Client::getInstance()->storeFile($s3FileKey, $_FILES['image']['tmp_name']);

        DB::getConnection()->commit(); // Commit database transaction

        http_response_code(201);
        echo json_encode(array('pokestop_id' => $pokestop_id));

    } catch (Exception $err) {

        DB::getConnection()->rollBack(); //rollback
        http_response_code(400);
        error_log($err);
        echo "Could not create pokestop";
    }
}

savePokestop();

function validateData() {
    if (!isset( $_POST['location']) || empty($_POST['location'])|| !preg_match("/^-?\d{1,3}\.\d+,-?\d{1,3}\.\d+$/", $_POST['location'])) {
        http_response_code(400);
        echo "Invalid location entered";
        exit();
    }

    if (!isset($_FILES['image']) || empty($_FILES['image'])) {
        http_response_code(400);
        echo "Pokestop image required";
        exit();
    }

    if (!isset($_POST['description']) || empty($_POST['description'])) {
        http_response_code(400);
        echo "Description field required";
        exit();
    } elseif (strlen($_POST['description']) > 250) {
        http_response_code(400);
        echo "Description exceeded maximum character length of 250";
        exit();
    }

    if (!isset($_POST['location_name']) || empty($_POST['location_name'])) {
        http_response_code(400);
        echo "Name field required";
        exit();
    } elseif (strlen($_POST['location_name']) > 100) {
        http_response_code(400);
        echo "Name exceeded maximum character length of 100";
        exit();
    }
}

function createPokestopInDatabase($s3ImageKey) {
    $location_name = $_POST['location_name'];
    $description = $_POST['description'];
    $location_type = $_POST['location_type'];
    $coords = explode(",", $_POST['location']);
    $lat = $coords[0];
    $long = $coords[1];
    $user_id = $_SESSION['user_id'];

    $pokestop_id = PokestopRepository::save($user_id, $location_name, $description, $location_type, $lat, $long, $s3ImageKey);
    return $pokestop_id;
}


