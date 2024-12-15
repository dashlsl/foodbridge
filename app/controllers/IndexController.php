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
        // Add news and updates here for carousel view

        return ViewManager::renderView('index_view');
    }
}