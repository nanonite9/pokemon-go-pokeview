<?php

/**
 * Singleton class for initialising and retrieving the MySQL database connection
 *
 */
class DB
{
    private static $instance = null;

    public static function getConnection() {
        if(self::$instance == null)
        {
            try
            {
                self::$instance = new PDO('mysql:host=localhost;dbname=pokeview', 'root', '');
            }
            catch(PDOException $e)
            {
                error_log($e->getMessage());
                exit('PDO Connection failed! - ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}