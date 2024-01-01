<?php

// Require the bootstrap file to initialize the application
$bootstrap = require_once __DIR__ . '/../app/bootstrap.php';
$app = $bootstrap['app'];
$debugBar = $bootstrap['debugBar'];

$response = $app->handleRequest();

if ($debugBar) {
    $debugBar->stopTimer('bootstrap');
    echo $debugBar->render();
}
 
if (is_array($response)) {
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo $response;
}
