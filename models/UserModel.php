<?php

class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }
}
