<?php

namespace App\Controllers;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Views\ViewManager;

class IndexController
{
    public function index(){
        return ViewManager::renderView('indexview');
    }
}