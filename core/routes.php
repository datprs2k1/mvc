<?php

class Routes
{

    private $routes = [
        'a/(.+)' => 'home/about/$1',
    ];

    public function handleRoutes($url)
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
}
