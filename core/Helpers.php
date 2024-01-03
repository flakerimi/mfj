<?php
/**
 * Helper functions
 * 
 * Define helper functions here, and they will be available globally in the application
 * Most likely, you will want to define functions that are used in multiple controllers or views
 * Whole idea of helpers is to avoid Class::method() syntax and use function() syntax instead
 * 
 * Example:
 * 
 * function config($key, $default = null) {
 *    return \Core\Config::get($key, $default);
 * }
 * 
 * Now you can use config() function in any controller or view
 * 
 * config('app.name') will return value of app.name key from config/app.php file
 * 
 * @package MVC
 * @subpackage Core
 * @version 1.0.0
 * @since 1.0.0
 *
 */

// Config helper function
function config($key, $default = null) {
    return \Core\Config::get($key, $default);
}

// Redirect helper function. Pass url or empty string to redirect to /, or pass null to redirect to current page
function redirect($url = null) {
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header('Location: ' . $url);
    exit;
}

// router aliases for REST API
// View helper function
function view($view, $data = []) {
    return \Core\View::view($view, $data);
} 