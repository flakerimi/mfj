<?php

namespace App\Controllers;

use Core\Controller;
use Core\Config;
use Core\View;

class HomeController extends Controller
{
    public function index()
    {
         $name = 'John';
         return View::view('home.index', ['name' => $name]);
    }
}
