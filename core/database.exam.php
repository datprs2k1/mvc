<?php

class Database extends PDO
{
    public function __construct()
    {
        $connect = "mysql:host=localhost;dbname=app;charset=UTF8";
        $user = "root";
        $pass = "";
        try {
            parent::__construct($connect, $user, $pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
