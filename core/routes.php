<?php


$controllers = [
    'Home' => ['index', 'about'],
];

$routes = [
    'about' => [
        'controller' => 'Home',
        'action' => 'about'
    ],
];

$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = trim($url, '/');
$url = explode('/', $url);


if (array_key_exists($url[0], $routes)) {
    $route = $routes[$url[0]];
    $controller = ucfirst($route['controller']);
    $action = $route['action'];
    if (!empty($url[1])) {
        $param = $url[1];
    }
} else {
    if (!empty($url[0])) {
        $controller = ucfirst($url[0]);
        if (!empty($url[1])) {
            $action = $url[1];
            if (!empty($url[2])) {
                $param = $url[2];
            }
        } else {
            $action = 'index';
        }
    } else {
        $controller = 'Home';
        $action = 'index';
    }
}

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'Home';
    $action = 'error';
}

include_once('controllers/' . $controller . 'Controller.php');

$controller_name = $controller . 'Controller';

$controller = new $controller_name();

if (isset($param)) {
    $controller->{$action}($param);
} else {
    $controller->{$action}();
}
