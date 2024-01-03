<?php

$bootstrap = require_once __DIR__ . '/../app/bootstrap.php';

$response = $bootstrap['response'];
$debugBarRenderer = $bootstrap['debugBarRenderer'];

// Handle the application response
echo $response;

// Render DebugBar if in debug mode
if ($debugBarRenderer) {
    echo $debugBarRenderer->renderHead();
    echo $debugBarRenderer->render();
 
}
