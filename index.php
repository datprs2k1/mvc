<?php

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
    } else {
        $action = 'index';
    }
} else {
    $controller = 'Home';
    $action = 'index';
}

require_once('database.php');

require_once('models/Model.php');

require_once('controllers/BaseController.php');

require_once('routes.php');
