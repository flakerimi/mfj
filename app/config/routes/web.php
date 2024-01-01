<?php
// Directly use $this->router which is an instance of Core\Router
//$this->router->get('/', 'HomeController@index');

$this->router->get('/', function() {
    // Instantiate the Controller and call the action method
    $controller = new \App\Controllers\HomeController();
    return $controller->index();
});

// Directly use $this->router which is an instance of Core\Router
$this->router->get('/user/{id}', function ($id) {
    return  $id;
});

$this->router->get('/welcome', function() {
    // Assuming `welcome` view exists and there is a logic to retrieve data
    $data = ['message' => 'Flak'];
    $view = 'welcome/index';  // Path to the HTML view

    return compact('data', 'view');
});

$this->router->get('/users', function() {
    // Logic to fetch users
    $users = ['Taylor', 'Dayle'];
    $view = 'users/index';  // Path to the HTML view
    return  compact('users', 'view');
});