<?php

class Response
{

    public function redirect($url)
    {
        if (preg_match('^(http|https)://', $url)) {
            $url = $url;
        } else {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $url;
        }

        header('Location: ' . $url);
        exit;
    }
}
