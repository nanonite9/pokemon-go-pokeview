<?php

require_once 'Constants.php';

/**
*   AWS S3 Configuration file
*  Key and Secret loaded from Constants.php file
*/
return array(
    // Bootstrap the configuration file with AWS specific features
    'includes' => array('_aws'),
    'services' => array(
        // All AWS clients extend from 'default_settings'. Here we are
        // overriding 'default_settings' with our default credentials and
        // providing a default region setting.
        'default_settings' => array(
            'params' => array(
                'credentials' => array(
                    'key'    => S3_BUCKET_ACCESS_KEY,
                    'secret' => S3_BUCKET_ACCESS_SECRET,
                )
            )
        )
    )
);
