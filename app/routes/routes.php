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
// Admin
$rm->get(
    '/get-user-list',
    'AdminController@getUserList');

$rm->get(
    '/get-donations',
    'AdminController@getDonations');


/** POST ROUTES */
// User
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

// Admin
$rm->post(
    '/edit-user',
    'AdminController@editUser');

$rm->post(
    '/delete-user',
    'AdminController@deleteUser');

$rm->post(
    '/update-donation',
    'AdminController@updateDonation');

$rm->post(
    '/delete-donation',
    'AdminController@deleteDonation');



$rm->handleRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);