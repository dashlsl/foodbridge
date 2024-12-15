<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Routes\RouteManager;

$rm = new RouteManager;

/** GET ROUTES */
// Index
$rm->get(
    '/', 
    'IndexController@index');

$rm->get(
    '/index.php', 
    'IndexController@index');

// User
$rm->get(
    '/register',
    'UserController@registerView');

$rm->get(
    '/login',
    'UserController@loginView');

$rm->get(
    '/edit-profile',
    'UserController@editProfileView');

$rm->get(
    '/logout',
    'UserController@logout');

// Admin
$rm->get(
    '/admin-user-list',
    'AdminController@adminUserListView');  // Default view

$rm->get(
    '/admin-order',
    'AdminController@adminOrderView');

/** GET ROUTES (AJAX) */
// User
$rm->get(
    '/get-user-list',
    'UserController@getUserList');

$rm->get(
    '/get-user-details',
    'UserController@getUserDetails');


/** POST ROUTES */
$rm->post(
    '/register',
    'UserController@register');

$rm->post(
    '/login',
    'UserController@login');

$rm->post(
    '/edit-profile',
    'UserController@editProfile');

$rm->post(
    '/update-password',
    'UserController@updatePassword');




$rm->handleRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);