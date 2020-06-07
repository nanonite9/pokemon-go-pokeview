<?php

/**
 * Defining constants for use by third party libraries, i.e., Google Map and AWS S3
 * Google Map API key and AWS S3 Access keys have been added to the Apache config as environment variables for security purposes
 */
define("S3_BUCKET_ACCESS_KEY", apache_getenv("S3_BUCKET_ACCESS_KEY"), false);
define("S3_BUCKET_ACCESS_SECRET", apache_getenv("S3_BUCKET_ACCESS_SECRET"), false);
define("GOOGLE_MAPS_API_KEY", apache_getenv("GOOGLE_MAPS_API_KEY"), false);

?>