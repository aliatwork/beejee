<?php

namespace App;

class Database
{

    const ORDER_ASCEND = 'ASC';
    const ORDER_DESCEND = 'DESC';

    const STATE_COMPLETED = 'completed';
    const STATE_NOT_COMPLETED = 'not_completed';

    const STATE_CHECKED = 'checked';
    const STATE_NOT_CEHCKED = 'not_checked';

    private static $instance = null;

    private $server = "localhost";
    private $database = "beejee";
    private $username = "root";
    private $password = "";

    private $conn = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function connect()
    {
        try {
            $this->conn = new \mysqli($this->server, $this->username, $this->password, $this->database);
            if (mysqli_connect_errno()) {
                throw new \Exception("DB connection error!");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function select($query)
    {
        $result = null;
        $data = [];
        try {
            $this->connect();
            if ($result = $this->conn->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                $result->close();
            } else {
                throw new \Exception("SQL query error! Error: " . $this->conn->error);
            }
            $this->conn->close();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $data;
    }

    private function execute($query)
    {
        try {
            $this->connect();
            if (!$this->conn->query($query)) {
                throw new \Exception("SQL query error! Error: " . $this->conn->error);
            }
            $this->conn->close();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public function getTasksList($sortField = '', $sortOrder = '', $limit = 0, $offset = 0)
    {
        $sortText = "";
        if ($sortField != '') {
            $sortText = " ORDER BY " . $sortField;
            if (in_array(strtoupper($sortOrder), [self::ORDER_ASCEND, self::ORDER_DESCEND])) {
                $sortText = " ORDER BY " . $sortField . " " . $sortOrder;
            }
        }
        $limitText = "";
        if ($limit > 0) {
            $limitText = " LIMIT " . $limit;
            if ($offset > 0) {
                $limitText = " LIMIT " . $offset . ", " . $limit;
            }
        }
        return $this->select("SELECT id, name, email, text, state, check_state FROM tasks " . $sortText . " " . $limitText);
    }

    public function getTasksCount()
    {
        $data = $this->select("SELECT COUNT(id) AS `count` FROM tasks");
        return $data[0]['count'];
    }

    public function addTask($name, $email, $text)
    {
        $name = strip_tags($name);
        $email = strip_tags($email);
        $text = strip_tags($text);
        return $this->execute("INSERT INTO tasks (name, email, text) VALUES ('" . $name . "', '" . $email . "', '" . $text . "')");
    }

    public function changeTaskText($id, $text)
    {
        $id = strip_tags($id);
        $text = strip_tags($text);
        return $this->execute("UPDATE tasks SET text = '" . $text . "' WHERE id = " . $id);
    }

    public function completeTask($id, $check)
    {
        $id = strip_tags($id);
        if (in_array($check, [self::STATE_COMPLETED, self::STATE_NOT_COMPLETED])) {
            return $this->execute("UPDATE tasks SET state = '" . $check . "' WHERE id = " . $id);
        }
        return false;
    }

    public function checkTask($id, $check)
    {
        $id = strip_tags($id);
        if (in_array($check, [self::STATE_CHECKED, self::STATE_NOT_CEHCKED])) {
            return $this->execute("UPDATE tasks SET check_state = '" . $check . "' WHERE id = " . $id);
        }
        return false;
    }

}