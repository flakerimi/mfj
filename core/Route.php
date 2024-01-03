<?php
namespace Core;

use FastRoute\RouteCollector;

class Route
{
    protected static $dispatcher;

    public static function setDispatcher(RouteCollector $dispatcher)
    {
        self::$dispatcher = $dispatcher;
    }

    public static function get($uri, $action) {
  
        self::$dispatcher->addRoute('GET', $uri, $action);
    }
    public static function post($uri, $action)
    {
        self::$dispatcher->addRoute('POST', $uri, $action);
    }

    public static function put($uri, $action)
    {
        self::$dispatcher->addRoute('PUT', $uri, $action);
    }

    public static function delete($uri, $action)
    {
        self::$dispatcher->addRoute('DELETE', $uri, $action);
    }

    public static function patch($uri, $action)
    {
        self::$dispatcher->addRoute('PATCH', $uri, $action);
    }

    public static function options($uri, $action)
    {
        self::$dispatcher->addRoute('OPTIONS', $uri, $action);
    }

    public static function any($uri, $action)
    {
        self::$dispatcher->addRoute(['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'], $uri, $action);
    }

    public static function group($prefix, $callback)
    {
        $callback();
    }

    public static function resource($uri, $controller)
    {
        self::get($uri, $controller . '@index');
        self::get($uri . '/{id:\d+}', $controller . '@show');
        self::get($uri . '/create', $controller . '@create');
        self::post($uri, $controller . '@store');
        self::get($uri . '/{id:\d+}/edit', $controller . '@edit');
        self::put($uri . '/{id:\d+}', $controller . '@update');
        self::delete($uri . '/{id:\d+}', $controller . '@destroy');
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
    public static function getDispatcherData() {
        return self::$dispatcher ? self::$dispatcher->getData() : null;
    }

}
