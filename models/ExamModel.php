<?php

class ExamModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'table_name';
    }
}
