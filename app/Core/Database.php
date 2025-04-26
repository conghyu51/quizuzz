<?php

namespace App\Core;

class Database
{
    public $conn;

    public function __construct($host, $user, $pass, $dbname)
    {
        $this->conn = new \mysqli($host, $user, $pass, $dbname);

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public function create($table, $data)
    {
        $columns = implode(",", array_keys($data));
        $values  = implode("','", array_map([$this->conn, 'real_escape_string'], array_values($data)));

        $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
        return $this->conn->query($sql);
    }

    public function update($table, $data, $where)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $safeValue = $this->conn->real_escape_string($value);
            $set[] = "$key='$safeValue'";
        }

        $setStr = implode(",", $set);
        $sql = "UPDATE $table SET $setStr WHERE $where";

        return $this->conn->query($sql);
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->conn->query($sql);
    }

    public function get($table, $where)
    {
        $sql = "SELECT * FROM $table WHERE $where";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function getMany($table, $where)
    {
        $sql = "SELECT * FROM $table WHERE $where";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function all($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function raw($sql)
    {
        return $this->conn->query($sql);
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}
