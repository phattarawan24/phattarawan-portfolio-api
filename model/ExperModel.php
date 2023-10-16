<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class ExperModel
{
    private $conn;
    private $table = "expericence";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
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
            $query = "SELECT * FROM " . $this->table . " WHERE id= :id ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }

  

    public function insert()
    {
        try {
            $query = "INSERT INTO " . $this->table . "(date, title, detail,type) VALUES (:date, :title, :detail, :type)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":detail", $this->detail);
            $stmt->bindParam(":type", $this->type);
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
            $query = "UPDATE " . $this->table . " SET date= :date, title= :title, detail= :detail, type= :type WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":detail", $this->detail);
            $stmt->bindParam(":type", $this->type);
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
            print_r($e);
            exit();
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
