<?php

$controllers = [
    'Home' => ['index', 'about'],
];

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'Home';
    $action = 'index';
}

include_once('controllers/' . $controller . 'Controller.php');

$controller_name = $controller . 'Controller';

if (isset($id)) {
    $controller = new $controller_name($id);
} else {
    $controller = new $controller_name();
}

$controller->$action();
