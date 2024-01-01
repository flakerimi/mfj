<?php

namespace Core;

class Controller {
    // Common properties and methods for controllers

    protected function redirect($url, $statusCode = 303) {
        header('Location: ' . $url, true, $statusCode);
        exit();
    }

    protected function render($view, $data = []) {
        View::render($view, $data);
    }

    protected function renderTemplate($template, $data = []) {
        View::renderTemplate($template, $data);
    }

    protected function renderJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function render404() {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        $this->renderTemplate('404.html');
    }

    protected function render403() {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        $this->renderTemplate('403.html');
    }

    protected function render500() {
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        $this->renderTemplate('500.html');
    }

    protected function renderError($message) {
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        $this->renderTemplate('error.html', ['message' => $message]);
    }
    
}
