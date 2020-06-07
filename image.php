<?php

require_once 'persistence/PokestopRepository.php';
require_once 'config/S3Client.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    displayNoImageAvailable();
    exit();
} else {
    getPokestopImageFromS3($_GET['id']);
}

/**
 * Step 1. Get the S3 Image key associated to the pokestop from the database
 * Step 2. Retrieve image file from S3
 * Step 3. Print the body of the image to the response
 * Step 4. Set the content type of the response to display the image correctly
 */
function getPokestopImageFromS3($pokeStopId) {
    $pokestop = PokestopRepository::findPokestop($pokeStopId);

    $s3FileKey = $pokestop['s3_image_key'];

    if (empty($s3FileKey)) {
        displayNoImageAvailable();
        exit();
    }

    $result = S3Client::getInstance()->getFile($s3FileKey);

    // Seek to the beginning of the stream
    $result['Body']->rewind();

    // Read the body off of the underlying stream in chunks
    while ($data = $result['Body']->read(1024)) {
        echo $data;
    }

    $fileExtension = pathinfo($s3FileKey, PATHINFO_EXTENSION);

    header('Content-type: ' . getContentType($fileExtension));
}

/**
 * Get content type for image format
 * @param $fileExtension
 * @return string
 */
function getContentType($fileExtension) {
    switch ($fileExtension) {
        case "gif":
           return "image/gif";
        case "png":
            return "image/png";
        case "jpeg":
        case "jpg":
            return "image/jpeg";
        case "svg":
            return "image/svg+xml";
        default:
    }
}

function displayNoImageAvailable() {
    echo file_get_contents('media/no-image-available.png');
}

