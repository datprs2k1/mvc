<?php
class Session
{
    public static function data($key, $value = '')
    {
        if (!empty($value)) {
            $_SESSION[$key] = $value;
        } else {
            return $_SESSION[$key];
        }
    }

    public static function delete($key)
    {
        if (!empty($key)) {
            unset($_SESSION[$key]);
        } else {
            unset($_SESSION);
        }
    }
}
