<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class SkillModel
{
    private $conn;
    private $table = "skills";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        try {
            $query = "SELECT id, title, level, created,type FROM " . $this->table . " ORDER BY id DESC";
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
            $query = "SELECT title, level FROM " . $this->table . " WHERE id= :id ORDER BY id DESC";
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
            $query = "INSERT INTO " . $this->table . "(title, level, created, updated) VALUES (:title, :level, :created, :updated)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":level", $this->level);
            $created = date('Y-m-d H:i:s');
            $updated = date('Y-m-d H:i:s');
            $stmt->bindParam(":created", $created);
            $stmt->bindParam(":updated", $updated);
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
            print_r($e);
            exit();
            return false;
        }
    }

    public function update()
    {
        try {
            $query = "UPDATE " . $this->table . " SET title= :title, level= :level, updated= :updated WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":level", $this->level);
            $updated = date('Y-m-d H:i:s');
            $stmt->bindParam(":updated", $updated);
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
