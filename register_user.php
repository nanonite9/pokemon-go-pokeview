<?php

require_once "persistence/UserRepository.php";

validateData();
saveUser();

function validateData() {
    if (!isset($_POST['email']) || empty($_POST['email']) || filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL) === false) {
        http_response_code(400);
        echo "'" . $_POST['email'] . "' is not a valid email address";
        exit();
    } elseif (!isset($_POST['gender']) || empty($_POST['gender']) || ($_POST['gender'] !== "Male" && $_POST['gender'] !== "Female" && $_POST['gender'] !== "Other")) {
        http_response_code(400);
        echo "'" . $_POST['gender'] . "' is not a valid gender";
        exit();
    } elseif (!isset($_POST['dob']) || empty($_POST['dob']) || !preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $_POST['dob'])) {
        http_response_code(400);
        echo "'" . $_POST['dob'] . "' is not a valid date of birth";
        exit();
    } elseif (!isset($_POST['pwd']) || empty($_POST['pwd'])) {
        http_response_code(400);
        echo "Password cannot be empty";
        exit();
    } elseif (!isset($_POST['username']) || empty($_POST['username'])) {
        http_response_code(400);
        echo "Username cannot be empty";
        exit();
    } elseif (!empty(UserRepository::findUserByEmailOrUsername($_POST['email'], $_POST['username']))) {
        http_response_code(400);
        echo "User already exists!";
        exit();
    }
}

function saveUser() {
    UserRepository::save($_POST['email'], $_POST['gender'], $_POST['dob'], $_POST['username'], $_POST['pwd']);
    echo "User successfully registered!";
}

