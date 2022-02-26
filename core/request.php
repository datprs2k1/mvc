<?php

class Request
{
    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isPost()
    {
        return self::getMethod() === 'POST';
    }

    public static function isGet()
    {
        return self::getMethod() === 'GET';
    }
    public function all()
    {
        $dataFiels = [];
        if ($this->isGet()) {
            if (isset($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $dataFiels[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFiels[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if ($this->isPost()) {
            if (isset($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataFiels[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFiels[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        return $dataFiels;
    }
}
