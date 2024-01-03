<?php 
use Core\Route;

Route::get('/', 'HomeController@index');
Route::get('/welcome', function () {

    echo 'Welcome to the homepage!';
});