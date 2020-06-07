<?php

require_once 'config/DB.php';

/**
 * Class ReviewRepository - Database layer for creating and retrieving Reviews
 */
class ReviewRepository
{
    /**
     * @param $id - pokestop_id
     * @return associative array of reviews and the associated user
     */
    public static function findReviewsWithUserByPokestop($id) {
        $sql = "SELECT reviews.*, users.username FROM reviews 
                INNER JOIN users ON users.user_id = reviews.user_id
                WHERE pokestop_id = :id ORDER BY review_id DESC";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':id' => $id));
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $review_id
     * @return associative array
     */
    public static function findReviewById($review_id) {
        $sql = "SELECT reviews.*, users.username FROM reviews 
                INNER JOIN users ON users.user_id = reviews.user_id
                WHERE review_id = :review_id";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':review_id' => $review_id));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Save review
     * @param $user_id
     * @param $pokestop_id
     * @param $review
     * @param $rating
     * @return string
     */
    public static function save($user_id, $pokestop_id, $review, $rating) {
        $sql = "INSERT INTO reviews (user_id, pokestop_id, review, rating) VALUES (:user_id, :pokestop_id, :review, :rating)";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':user_id' => $user_id, ':pokestop_id' => $pokestop_id, ':review' => $review, ':rating' => $rating));
        return DB::getConnection()->lastInsertId("reviews");
    }

}

