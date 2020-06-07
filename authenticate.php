<?php

require_once 'persistence/UserRepository.php';

session_start();
authenticateUser();

/**
 * Authenticate user login
 */
function authenticateUser() {
    $username = $_POST['uname'];
    $password = $_POST['pwd'];

    $user = UserRepository::findUserByUsername($username);

    if (password_verify($password, $user['password'])) {

        session_regenerate_id();
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['user_id'];

        http_response_code(200);
        echo "User successfully logged in!";

    } else {
        http_response_code(401);
        echo "Invalid username or password";
    }
}

