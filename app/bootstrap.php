<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Helpers.php';
$dbConfig = require_once __DIR__ . '/../app/config/database.php';

use DebugBar\StandardDebugBar;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$isDebugMode = isset($_ENV['DEBUG_MODE']) ? $_ENV['DEBUG_MODE'] === 'true' : false;

if ($isDebugMode) {
    $debugBar = new StandardDebugBar();
    $debugBarRenderer = $debugBar->getJavascriptRenderer();
    $debugBar['time']->startMeasure('bootstrap', 'Bootstrap process');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

$db = new Core\Database($dbConfig);
$router = new Core\Router();
$view = new Core\View();

require_once __DIR__ . '/../app/routes.php';

$response = dispatchRequest($router);

if ($isDebugMode) {
    $debugBar['time']->stopMeasure('bootstrap');
}

return [
    'response' => handleResponseFormat($response),
    'debugBarRenderer' => $isDebugMode ? $debugBarRenderer : null
];

function dispatchRequest($router) {
    global $isDebugMode, $debugBar;

    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = $_SERVER['REQUEST_URI'];

    if ($isDebugMode) {
        $debugBar['time']->startMeasure('dispatching', 'Dispatching request');
    }

    try {
        $result = $router->dispatch($requestMethod, $requestUri);

        if ($isDebugMode) {
            $debugBar['time']->stopMeasure('dispatching');
        }

        if (is_array($result) && isset($result['error'])) {
            if ($result['error'] === '404 Not Found') {
                return [
                    'error' => $result['error'],
                    'message' => 'The requested URI ' . $requestUri . ' could not be found.'
                ];
            } else {
                $message = isset($result['message']) ? $result['message'] : 'An error occurred during routing.';
                return ['error' => $result['error'], 'message' => $message];
            }
        }

        return $result;

    } catch (Exception $e) {
        if ($isDebugMode) {
            $debugBar['exceptions']->addException($e);
        }
        return [
            'error' => 'Internal Server Error',
            'message' => $e->getMessage()
        ];
    }
}

function handleResponseFormat($response) {
    global $responseFormat;
    $responseFormat = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_EXTENSION);
    $isJsonResponse = $responseFormat === 'json';

    if ($isJsonResponse) {
        header('Content-Type: application/json');
        return json_encode($response);
    } else {
        if (is_array($response) && isset($response['error'])) {
            $errorMessage = isset($response['message']) ? $response['message'] : 'An unknown error occurred';
            header('HTTP/1.1 404 Not Found');
            return "Error: " . $response['error'] . ". " . $errorMessage;
        } else {
            return $response;
        }
    }
}
