<?php

# Prevent direct access to this file.
if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

/**
 * Database configuration.
 * 
 * @var array $dbConfig
 */
$dbConfig = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'foodbridge'
];
