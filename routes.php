<?php

$controllers = [
    'Home' => ['index', 'about'],
];

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'Home';
    $action = 'error';
}

include_once('controllers/' . $controller . 'Controller.php');

$controller_name = $controller . 'Controller';

$controller = new $controller_name();

if (isset($id)) {
    $controller->{$action}($id);
} else {
    $controller->{$action}();
}
