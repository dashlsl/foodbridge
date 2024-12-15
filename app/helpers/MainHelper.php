<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

/** Autoload classes */
function autoload($className)
{
    $className = str_replace('\\', '/', $className);
    $filePath = ROOT . '/' . $className . '.php';

    if (file_exists($filePath)) {
        require_once $filePath;

    } else {
        throw new \Exception("Class $className not found in $filePath");
    }
}

spl_autoload_register('autoload');