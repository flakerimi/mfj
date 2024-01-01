<?php

namespace Core;

class App {
    protected $router;
    protected $variables;


    public function __construct(Router $router, $variables = []) {
        $this->router = $router;
        $this->variables = $variables;

    }

    public function loadRoutes() {
        // Load the routes from app/config/routes/
        $routePath = __DIR__ . '/../app/config/routes/';

        // Scan the route directory for files
        $files = scandir($routePath);

        // Loop through the files
        foreach ($files as $file) {
            if (strpos($file, '.php') !== false) {
                require $routePath . $file;
            }
        }
        
    }

    public function handleRequest() {
        return $this->router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }

    public function getVariable($key) {
        return isset($this->variables[$key]) ? $this->variables[$key] : null;
    }
    
}
