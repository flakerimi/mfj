<?php
// app/bootstrap.php

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// add helpers
require_once __DIR__ . '/../Core/Helpers.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Set up error handling based on debug mode, which is set in .env file
$isDebugMode = isset($_ENV['DEBUG_MODE']) ? $_ENV['DEBUG_MODE'] === 'true' : false;

if ($isDebugMode) {
    $debugBar = new Core\DebugBar();
    $debugBar->startTimer('bootstrap');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Initialize the core components
$router = new Core\Router();
$view = new Core\View();
$app = new Core\App($router);

// Create an array of variables to pass to the App class
$variables = ['view' => $view];

// Load application routes
$app->loadRoutes();

// Return the App instance and DebugBar for use in index.php
return ['app' => $app, 'debugBar' => $debugBar];
