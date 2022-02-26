<?php

class HomeController extends BaseController
{

    public function index()
    {
        $data = [
            'message' => 'This is homepage',
            'title' => 'Homepage',
        ];

        $this->view('home.index', $data);
    }

    public function about()
    {
        echo 'Hello from the about action in the HomeController';
    }

    public function error()
    {
        echo 'Error 404';
    }
}
