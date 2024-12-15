<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Views\ViewManager;

$vm = new ViewManager();

// Add views
$vm->addView(
    'IndexView', 
    'Home', 
    ['indexview.css']);

$vm->addview(
    'InvalidView', 
    '404', 
    ['invalidview.css']);

$vm->addView(
    'DBSetupView', 
    'Database Setup', 
    ['databasesetup-view.css']);

$vm->addView(
    'registerview',
    'Register',
    ['registerview.css'],
    ['registerview.js']);

$vm->addView(
    'loginview',
    'Login',
    ['loginview.css'],
    ['loginview.js']);

$vm->addView(
    'editprofileview',
    'Profile',
    ['editprofileview.css'],
    ['editprofileview.js'],
    ['public'],
    true);