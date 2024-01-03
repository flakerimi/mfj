<?php

namespace Core;

class Controller {
    // Common properties and methods for controllers

    public function __construct() {
        // Constructor
        
    }
    
    public function model($model) {
        // Load model
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        // Load view
        require_once '../app/views/' . $view . '.php';
    }

    
}
