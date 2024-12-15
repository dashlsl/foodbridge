<?php

namespace App\Views;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

class ViewManager
{
    /** Add view */
    public function addView(
        $viewName, 
        $viewTitle, 
        $viewCss = [], // Optional
        $viewJs = [], // Optional
        $permission = [], // Optional: for permission checking
        $login = false // Optional: for login checking
        ) 
    {
        // more to do here
    }

    /** Render view based on view name */
    public static function renderView(
        $viewName, 
        $params = [], // Optional: for passing data to view
        $navName = [] // Optional: for rendering navigation bar
        )
    {
        // meow meow
    }

}
