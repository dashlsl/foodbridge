<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

/**
 * Database configuration.
 */
$dbConfig = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'foodbridge'
];
