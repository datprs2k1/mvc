<?php

class Exam extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'table_name';
    }
}
