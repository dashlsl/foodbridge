<?php

namespace App\Helpers;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

class AjaxHelper
{
    /**
     * AJAX is used to handle data and return JSON response
     */
    public static function sendResponse( $success, $data = [])
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success, 
            'data' => $data]);
        exit();
    }
}
