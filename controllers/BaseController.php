<?php

class BaseController
{
    protected $view_folder = 'views';

    public function view($file, $data = [])
    {
        $view_file = $this->view_folder . '/' . str_replace('.', '/', $file) . '.php';

        if (file_exists($view_file)) {
            extract($data);
            ob_start();
            require_once $view_file;
            $content = ob_get_clean();
            require_once 'views/layouts/application.php';
        } else {
            echo 'View file does not exist!';
        }
    }

    public function view_admin($file, $data = [])
    {
        $view_file = $this->view_folder . '/' . str_replace('.', '/', $file) . '.php';

        if (file_exists($view_file)) {
            extract($data);
            ob_start();
            require_once $view_file;
            $content = ob_get_clean();
            require_once 'views/layouts/applicationAdmin.php';
        } else {
            echo 'View file does not exist!';
        }
    }

    public function model($model)
    {
        $model_file = 'models/' . $model . '.php';

        require_once $model_file;

        return new $model();
    }
}
