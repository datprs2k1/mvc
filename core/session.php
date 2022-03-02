<?php
class Session
{
    public static function data($key, $value = '')
    {
        if (!empty($value)) {
            $_SESSION[$key] = $value;
        } else {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            } else {
                return false;
            }
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

    public static function flash($key, $value = '')
    {
        $data = self::data($key, $value);

        if (empty($value)) {
            self::delete($key);
        }

        return $data;
    }
}
