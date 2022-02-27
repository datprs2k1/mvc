<?php


$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = explode('/', $url);

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

require_once('core/database.php');

require_once('models/Model.php');

require_once('core/request.php');

require_once('controllers/BaseController.php');

require_once('core/routes.php');

$request = new Request();
