<?php
// core/View.php

namespace Core;

use Jenssegers\Blade\Blade;

class View {
    protected $blade;

    public function __construct() {
        // Define the path to your views and cache directory
        $views = __DIR__ . '/../app/views';
        $cache = __DIR__ . '/../storage/views';

        // Create a Blade instance
        $this->blade = new Blade($views, $cache);
    }

    public function render($view, $data = []) {
        return $this->blade->make($view, $data)->render();
    }

    public static function view($view, $data = []) {
        return  (new self())->render($view, $data);
    }
}
