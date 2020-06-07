<?php
/**
 * Logout - Destroy session and redirect user to homepage
 */
session_start();
session_destroy();

header('Location: index.php');