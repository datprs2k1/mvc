<?php

class Model extends Database
{
    protected $db = [];
    protected $table;
    protected $selectColumn = '*';
    protected $where = '';
    protected $operators = '';
    protected $order = '';
    protected $limit = '';
    protected $innerJoin = '';


    public function __construct()
    {
        $this->db = new Database();
    }

    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data)));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function update($data)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "{$key} = '{$value}'";
        }

        $set = implode(', ', $set);

        $sql = "UPDATE {$this->table} SET {$set}";

        if ($this->where) {
            $sql .= " WHERE {$this->where}";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function get()
    {
        $sql = "SELECT {$this->selectColumn} FROM {$this->table} {$this->where} {$this->order} {$this->limit}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->resetQuery();
        return $result;
    }

    public function first()
    {
        $this->limit = "LIMIT 1";
        $result = $this->get();
        return $result[0];
    }

    public function find($id)
    {
        $this->where = "WHERE id = {$id}";
        $result = $this->get();
        return $result[0];
    }

    public function join($table, $on)
    {
        $this->innerJoin = "INNER JOIN {$table} ON {$on}";
        return $this;
    }

    public function where($column, $operator, $value)
    {
        if (!empty($this->where)) {
            $this->where .= ' AND ';
        } else {
            $this->where .= ' WHERE ';
        }

        $this->where .= $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function whereLike($column, $value)
    {
        if (!empty($this->where)) {
            $this->where .= ' AND ';
        } else {
            $this->where .= ' WHERE ';
        }

        $this->where .= $column . ' LIKE "%' . $value . '%"';
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        if (!empty($this->where)) {
            $this->where .= ' OR ';
        } else {
            $this->where .= ' WHERE ';
        }

        $this->where .= $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function limit($limit = 10, $offset = 0)
    {
        $this->limit = " LIMIT {$offset}, {$limit}";
        return $this;
    }

    public function orderBy($column, $order)
    {
        if (!empty($this->order)) {
            $this->order .= ', ';
        } else {
            $this->order .= ' ORDER BY ';
        }

        $this->order .= $column . ' ' . $order;
        return $this;
    }

    public function select($column)
    {
        $this->selectColumn = $column;
        return $this;
    }

    public function resetQuery()
    {
        $this->selectColumn = '*';
        $this->where = '';
        $this->operators = '';
        $this->order = '';
        $this->limit = '';
        $this->innerJoin = '';
    }
}
