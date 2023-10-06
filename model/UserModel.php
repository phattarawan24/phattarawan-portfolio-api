<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        try {
            $query = "SELECT id, first_name, last_name, phone FROM " . $this->table . " ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getById()
    {
        try {
            $query = "SELECT first_name, last_name FROM " . $this->table . " WHERE id= :id ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getByPhone()
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE phone= :phone ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insert()
    {
        try {
            $query = "INSERT INTO " . $this->table . "(first_name, last_name, phone) VALUES (:first_name, :last_name, :phone)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":phone", $this->phone);
            if ($stmt->execute()) {
                $stmt_last_id = $this->conn->query("SELECT LAST_INSERT_ID()");
                $lastId = $stmt_last_id->fetchColumn();
                if ($stmt->rowCount()) {
                    return $lastId;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update()
    {
        try {
            $query = "UPDATE " . $this->table . " SET first_name= :first_name, last_name= :last_name, phone= :phone WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":id", $this->id);
            if ($stmt->execute()) {
                if ($stmt->rowCount()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete()
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            if ($stmt->execute()) {
                if ($stmt->rowCount()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}
