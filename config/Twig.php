<?php

require_once __DIR__ .'/../vendor/autoload.php';

/**
 * Twig: PHP Template Engine - Used in the presentation layer of the application
 *
 * Twig config file specifying location of template files
 *
 */
$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new Twig\Environment($loader);




