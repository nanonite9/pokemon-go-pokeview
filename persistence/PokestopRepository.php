<?php

require_once 'config/DB.php';

/**
 * Class PokestopRepository - Database layer for creating and retrieving Pokestops
 */
class PokestopRepository
{
    /**
     * @param $id - pokestop_id
     * @return associative array of requested pokestop
     */
    public static function findPokestop($id) {
        $sql = "SELECT pokestops.*, ROUND((IFNULL(AVG(reviews.rating), 1)), 0) AS average_rating FROM pokestops
                LEFT OUTER JOIN reviews ON reviews.pokestop_id = pokestops.pokestop_id
                WHERE pokestops.pokestop_id = :id
                GROUP BY pokestops.pokestop_id";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':id' => $id));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return associative array of all pokestops
     */
    public static function findAllPokestops() {
        $sql = "SELECT pokestops.*, ROUND((IFNULL(AVG(reviews.rating), 1)), 0) AS average_rating FROM pokestops
                LEFT OUTER JOIN reviews ON pokestops.pokestop_id = reviews.pokestop_id 
                GROUP BY pokestops.pokestop_id";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $location_name - name of pokestop
     * @return associative array of all pokestops containing the name
     */
    public static function findPokestopsByName($location_name) {
        $sql = "SELECT pokestops.*, ROUND((IFNULL(AVG(reviews.rating), 1)), 0) AS average_rating FROM pokestops
                LEFT OUTER JOIN reviews ON pokestops.pokestop_id = reviews.pokestop_id 
                WHERE location_name like :location_name
                GROUP BY pokestops.pokestop_id";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':location_name' => '%' . $location_name . '%')); // Wildcard used to retrieve pokestops containing the string
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $rating - pokestop review rating
     * @return associative array
     */
    public static function findPokestopsByReviewRating($rating) {
        $sql = "SELECT pokestops.*, ROUND((IFNULL(AVG(reviews.rating), 1)), 0) AS average_rating FROM pokestops
                LEFT OUTER JOIN reviews ON pokestops.pokestop_id = reviews.pokestop_id 
                WHERE reviews.rating = :rating
                GROUP BY pokestops.pokestop_id";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':rating' => $rating));
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Save pokestop
     * @param $user_id
     * @param $location_name
     * @param $description
     * @param $location_type
     * @param $latitude
     * @param $longitude
     * @param $s3ImageKey
     * @return string
     */
    public static function save($user_id, $location_name, $description, $location_type, $latitude, $longitude, $s3ImageKey) {
        $sql = "INSERT INTO `pokestops` (`user_id`, `location_name`, `description`, `latitude`, `longitude`, `location_type`, `s3_image_key`) VALUES (:user_id, :location_name, :description, :latitude, :longitude, :location_type, :s3_image_key)";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':user_id' => $user_id, ':location_name' => $location_name, ':description' => $description, ':location_type' => $location_type, ':latitude' => $latitude, ':longitude' => $longitude, ':s3_image_key' => $s3ImageKey));
        return DB::getConnection()->lastInsertId("pokestops");
    }

}

