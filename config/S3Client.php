<?php

require_once __DIR__ .'/../vendor/autoload.php';

use Aws\Common\Aws;

/**
 * Class S3Client
 *  Wrapper class created to manage the storage and retrieval of image files from an S3 Bucket
 */
class S3Client {

    public $client;

    private $bucket = 'pokeview';

    private static $instance = null;

    /**
     * S3Client constructor.
     */
    public function __construct()
    {
        // Get the client from the builder by namespace
        $aws = Aws::factory(__DIR__ . '/aws_config.php');
        $this->client = $aws->get('S3');
    }

    /**
     * @return S3Client
     */
    public static function getInstance() {
        if(self::$instance == null)
        {
            try
            {
                self::$instance = new S3Client();
            }
            catch(Exception $e)
            {
                error_log($e->getMessage());
                exit('S3 Client Connection failed! - ' . $e->getMessage());
            }
        }
        return self::$instance;
    }


    /**
     * @param $key - Unique key associated required for storing the image file in S3
     * @param $filePath - Path to the image file on the server
     * @return result of storing file in S3
     */
    public function storeFile($key, $filePath)
    {
        return $this->client->putObject(array(
            'Bucket' => $this->bucket,
            'Key' => $key,
            'SourceFile' => $filePath
        ));
    }

    /**
     * @param $key - Unique key associated to image file
     * @return response from S3 containing the image file in binary format
     */
    public function getFile($key) {
        return $this->client->getObject(array(
            'Bucket' => $this->bucket,
            'Key'    => $key
        ));
    }
}




