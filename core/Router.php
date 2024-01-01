<?php

namespace Core;

class Router {
    protected $routes = [];

    public function addRoute($method, $uri, $action) {
        $this->routes[strtoupper($method)][$uri] = $action;
    }

    public function view($uri, $view, $data = []) {
        $this->addRoute('GET', $uri, function() use ($view, $data) {
            // Implement view rendering logic here
            return (new View())->render($view, $data);
        });
    }

    public function get($uri, $action = null) {
        if (is_null($action)) {
            // If action is not provided, infer the view path
            $this->addRoute('GET', $uri, function() use ($uri) {
                $view = $this->inferViewPath($uri);
                $data = [];  // Default data, modify as needed
                return compact('view', 'data');
            });
        } else {
            $this->addRoute('GET', $uri, $action);
        }
    }

    private function inferViewPath($uri) {
        // Convert route to view path, e.g., '/users' to 'users/index'
        return trim($uri, '/') . '/index';
    }

    public function post($uri, $action) {
        $this->addRoute('POST', $uri, $action);
    }

    public function put($uri, $action) {
        $this->addRoute('PUT', $uri, $action);
    }

    public function delete($uri, $action) {
        $this->addRoute('DELETE', $uri, $action);
    }

    private function convertToRegex($route) {
        return "/^" . str_replace('/', '\/', preg_replace('/\{([^}]+)\}/', '([^/]+)', $route)) . "$/";
    }

    public function dispatch($requestMethod, $uri) {
        $extension = pathinfo($uri, PATHINFO_EXTENSION);
        $uri = rtrim($uri, '.' . $extension);  // Remove the extension from URI

        $methodRoutes = $this->routes[strtoupper($requestMethod)] ?? [];
        foreach ($methodRoutes as $route => $action) {
            if (preg_match($this->convertToRegex($route), $uri, $matches)) {
                $response = call_user_func_array($action, array_slice($matches, 1));
                return $this->formatResponse($response, $extension);
            }
        }

        return $this->formatResponse(["error" => "404 Not Found"], 'html');
    }

    private function formatResponse($response, $extension) {
        $format = $extension === 'json' ? 'json' : 'html';
        
        if ($format === 'json') {
            header('Content-Type: application/json');
            return json_encode(is_array($response) ? $response : ["data" => $response]);
        } else {
            // Render HTML view if specified in the response array
            if (is_array($response) && isset($response['view'])) {
                return (new View())->render($response['view'], $response['data'] ?? []);
            }
            // If no view is specified, return the response as is (could be a string or other format)
            return $response;
        }
    }
}
