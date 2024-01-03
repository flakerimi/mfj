<?php


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
        // Check if the specified view exists
        if ($this->blade->exists($view)) {
            // Render the specified view
            $content = $this->blade->make($view, $data)->render();

            // Extend the default layout if it exists
            if ($this->blade->exists('layouts.default')) {
                return $this->blade->make('layouts.default', ['content' => $content])->render();
            }

            return $content; // Return the rendered view without a layout if 'layouts.default' doesn't exist
        }

        // View doesn't exist, return an error message or handle it as needed
        return "View '$view' not found.";
    }

    public static function view($view, $data = []) {
        return  (new self())->render($view, $data);
    }
}
