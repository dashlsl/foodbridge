<?php

namespace App\Routes;

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

use App\Models\UserModel;
use App\Models\DatabaseModel;
use App\Views\ViewManager;

class RouteManager
{
    private $routeList = [];

    /** Handle route based on request URI and request method. */
    public function handleRoute($requestURI, $requestMethod)
    {
        $this->checkBeforeRoute();
        
        $requestURI = $this->cleanURI($requestURI);

        // Find matching route
        $matchedRoute = null;
        foreach ($this->routeList as $route) {
            if ($route['uri'] === $requestURI && $route['method'] === $requestMethod) {
                $matchedRoute = $route;
                break;
            }
        }

        // Redirect to 404 page if route not found
        if ($matchedRoute === null) {
            ViewManager::renderView('invalidview');
            exit();
        }

        // Call controller method
        [$controller, $method] = explode('@', $matchedRoute['route']);
        $controller = 'App\\Controllers\\' . $controller;

        if (!class_exists($controller)) {
            throw new \Exception('Controller not found');
        }

        $ctrlObj = new $controller;

        if (!method_exists($ctrlObj, $method)) {
            throw new \Exception('Method not found');
        }

        $ctrlObj->$method();
    }

    /** Remove trailing slash from URI.
     * Keep if URI is /foodbridge/
     */
    private function cleanURI($uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        return ($path !== '/foodbridge/') ? rtrim($path, '/') : $path;
    }

    /** Add route to route list. */
    private function addRoute($uri, $route, $method)
    {
        $this->routeList[] = [
            'uri' => '/foodbridge' . $uri,
            'route' => $route,
            'method' => $method
        ];
    }

    /** Add GET route to route list. */
    public function get($uri, $route)
    {
        $this->addRoute($uri, $route, 'GET');
    }

    /** Add POST route to route list. */
    public function post($uri, $route)
    {
        $this->addRoute($uri, $route, 'POST');
    }

    /** Check before routing request. */
    private function checkBeforeRoute()
    {
        // Check if database is setup
        if (!DatabaseModel::validateDbSetup()) {
            ViewManager::renderView('installerview');
            exit();
        } else {
            // DatabaseModel::validateSampleSetup();
        }
        
        // Check if user is logged in
        $um = new UserModel();
        $um->validateLoginStatus();
    }
}