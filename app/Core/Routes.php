<?php

namespace App\Core;


class Routes
{
    private array $routes = [];

    public function get($path, $action)
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post($path, $action)
    {
        $this->routes['POST'][$path] = $action;
    }


    public function dispatch($method, $uri)
    {

        $path = parse_url($uri, PHP_URL_PATH);
        $queryParams = [];
        $queryString = parse_url($uri, PHP_URL_QUERY);
        
        if (!is_null($queryString)) {
            parse_str($queryString, $queryParams);
        }

        $bodyParams = [];
        if ($method === 'POST' || $method === 'PUT') {
            if (!empty($_POST¤)) {
                $bodyParams = $_POST; 
            }
            if (!empty($_FILES)) {
                $bodyParams['event_image'] = $_FILES['event_image'];
            }
        }

        $request = array_merge($queryParams, $bodyParams);
        
        
        if (isset($this->routes[$method][$path])) {
            [$class, $method] = $this->routes[$method][$path];
            $controller = new $class();
            $controller->$method($request);
        }
    }
}
