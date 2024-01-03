<?php

namespace Core;

use Core\Route;
use FastRoute\Dispatcher;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;



class Router
{
    protected $dispatcher;
    protected $route;

    public function __construct()
    {
        $routeParser = new Std();
        $dataGenerator = new GroupCountBased();
        $routeCollector = new RouteCollector($routeParser, $dataGenerator);

        // Set the dispatcher in Route class
        Route::setDispatcher($routeCollector);

        // Include your routes definitions
        require_once __DIR__ . '/../app/routes.php';

        // Now, create the dispatcher using the data from the route collector
        $this->dispatcher = new Dispatcher\GroupCountBased($routeCollector->getData());
    }


    public function dispatch($requestMethod, $uri)
    {
         // Dispatch the route based on the request method and URI
        $routeInfo = $this->dispatcher->dispatch($requestMethod, $uri);
 
        // Handle the result of the route dispatch
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // Handle 404 Not Found
                return $this->formatResponse(["error" => "404 Not Found"], 'html');
            case Dispatcher::METHOD_NOT_ALLOWED:
                // Handle 405 Method Not Allowed
                return $this->formatResponse(["error" => "405 Method Not Allowed"], 'html');
            case Dispatcher::FOUND:
                // Handle the found route and execute the associated action
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                if (is_callable($handler)) {
                    // If handler is a closure
                    $response = call_user_func_array($handler, $vars);
                } elseif (is_string($handler)) {
                    // If handler is a 'Controller@method' string

                    [$controllerName, $methodName] = explode('@', $handler);
                    $controllerFullName = "App\\Controllers\\$controllerName"; // Adjust the namespace
                    $controller = new $controllerFullName();
                     $response = call_user_func_array([$controller, $methodName], $vars);
                }
                return $this->formatResponse($response, 'html');

                // You can implement your logic here to execute the route handler
                // and pass the appropriate variables
                break;
        }
    }

    // Other methods for handling route responses and formatting

    private function formatResponse($response, $extension)
    {
        $format = $extension === 'json' ? 'json' : 'html';
        if ($format === 'json') {
            header('Content-Type: application/json');
            return json_encode(is_array($response) ? $response : ["data" => $response]);
        } else {
            // Assuming HTML response - check if it's an array with 'view'
            if (is_array($response) && isset($response['view'])) {
                return view($response['view'], $response['data'] ?? []);
            }
            return $response;
        }
    }


    public static function redirect($url = null)
    {
        if ($url === null) {
            $url = $_SERVER['REQUEST_URI'];
        } else if ($url === '') {
            $url = '/';
        }
        header('Location: ' . $url);
        exit;
    }
}
