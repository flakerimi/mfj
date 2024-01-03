<?php

namespace App\Controllers;

use Core\Controller;
 
class HomeController extends Controller
{
    public function index()
    {
         $name = 'John';
         return view('welcome.index' );
    }

    public function hello()
    {
        echo view('welcome.hello');
    }

    public function about()
    {
        return redirect('/home');
    }
}
