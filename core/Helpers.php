<?php

function config($key, $default = null) {
    return \Core\Config::get($key, $default);
}

function view($view, $data = []) {
    return \Core\View::view($view, $data);
}

