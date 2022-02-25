<?php

class Model extends Database
{
    protected $db = [];
    protected $table;


    public function __construct()
    {
        $this->db = new Database();
    }

    public function get($select = ['*'], $where = [], $orderby = [], $limit = 10)
    {
        $sql = "SELECT ";

        if (is_array($select)) {
            $sql .= implode(', ', $select);
        } else {
            $sql .= $select;
        }

        $sql .= " FROM " . $this->table;

        if (is_array($where) && count($where) > 0) {
            $sql .= " WHERE ";
            foreach ($where as $key => $value) {
                $sql .= $key . " = ";
                if (is_int($value)) {
                    $sql .= $value;
                } else {
                    $sql .= "'" . $value . "'";
                }
                $sql .= " AND ";
            }
            $sql = rtrim($sql, " AND ");
        }

        if (is_array($orderby) && count($orderby) > 0) {
            $sql .= " ORDER BY ";
            foreach ($orderby as $key => $value) {
                $sql .= $key . " " . $value . ", ";
            }
            $sql = rtrim($sql, ", ");
        }

        $sql .= " LIMIT " . $limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function findbyID($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = " . $id;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->table . " (";
        $sql .= implode(', ', array_keys($data));
        $sql .= ") VALUES ('";
        $sql .= implode("', '", array_values($data));
        $sql .= "')";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function update($data, $where)
    {
        $sql = "UPDATE " . $this->table . " SET ";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i > 0) {
                $sql .= ", ";
            }
            $sql .= $key . " = '" . $value . "'";
            $i++;
        }

        $sql .= " WHERE ";
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i > 0) {
                $sql .= " AND ";
            }
            $sql .= $key . " = '" . $value . "'";
            $i++;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function delete($where)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE ";
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i > 0) {
                $sql .= " AND ";
            }
            $sql .= $key . " = '" . $value . "'";
            $i++;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }
}
