<?php

class HomeController extends BaseController
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('Home');
    }

    public function index()
    {
        $data['user'] = $this->userModel->get(['id', 'username'], ['id' => '1']);

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
