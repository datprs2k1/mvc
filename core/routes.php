<?php

class Routes
{

    private $routes = [
        'a/(.+)' => 'home/about/$1',
    ];

    private $controllers = [
        'Home' => ['index', 'about'],
    ];

    public function __construct()
    {
        $this->handleUrl();
    }

    public function getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        return $url;
    }

    public function routes($url)
    {
        if (!empty($this->routes)) {
            foreach ($this->routes as $key => $value) {
                if (preg_match('~' . $key . '~', $url)) {
                    $url = preg_replace('~' . $key . '~', $value, $url);
                }
            }
        }
        return $url;
    }

    public function handleUrl()
    {
        $url = $this->getUrl();
        $url = $this->routes($url);
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

        if (!array_key_exists($controller, $this->controllers) || !in_array($action, $this->controllers[$controller])) {
            $controller = 'Home';
            $action = 'error';
        }

        include_once('./controllers/' . $controller . 'Controller.php');

        $controller_name = $controller . 'Controller';

        $controller = new $controller_name();

        if (isset($param)) {
            $controller->{$action}($param);
        } else {
            $controller->{$action}();
        }
    }
}
