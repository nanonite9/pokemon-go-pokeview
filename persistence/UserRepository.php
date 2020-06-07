<?php

require_once 'config/DB.php';

/**
 * Class UserRepository - Database layer for creating and retrieving Users
 */
class UserRepository
{
    /**
     * Find user by email or username
     * @param $email
     * @param $username
     * @return associative array of users
     */
    public static function findUserByEmailOrUsername($email, $username) {
        $sql = "SELECT * FROM users WHERE email = :email OR username = :username";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':email' => $email, ':username' => $username));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $username
     * @return associative array
     */
    public static function findUserByUsername($username) {
        $sql = "SELECT user_id, username, password FROM users WHERE username = :username";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array('username' => $username));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Save user
     * @param $email
     * @param $gender
     * @param $dob
     * @param $username
     * @param $pwd
     * @return mixed
     */
    public static function save($email, $gender, $dob, $username, $pwd) {
        $sql = "INSERT INTO users (email, gender, dob, username, password) VALUES (:email, :gender, :dob, :username, :password)";
        $sth = DB::getConnection()->prepare($sql);
        $sth->execute(array(':email' => $email, ':gender' => $gender, ':dob' => $dob, ':username' => $username, ':password' => password_hash($pwd, PASSWORD_BCRYPT)));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
}


