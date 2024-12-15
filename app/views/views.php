<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Views\ViewManager;

$vm = new ViewManager();

// Add navbars
$vm->addNav(
    'main_nav',
    ['main_nav.css']);

// Add views
$vm->addView(
    'index_view', 
    'Home', 
    ['styles.css']);

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
    'login_view',
    'Login',
    ['styles.css']);

$vm->addView(
    'editprofileview',
    'Profile',
    ['editprofileview.css'],
    ['editprofileview.js'],
    ['public'],
    true);