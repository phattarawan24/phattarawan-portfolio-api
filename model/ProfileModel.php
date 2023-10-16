<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class ProfileModel
{
    private $conn;
    private $table = "profile";

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
            $query = "INSERT INTO " . $this->table . "(first_name, last_name, phone, email, birthday, img) VALUES (:first_name, :last_name, :phone, :email, :birthday, :img)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":birthday", $this->birthday);
            $stmt->bindParam(":img", $this->img);
            $stmt->bindParam(":degree", $this->degree);
            $stmt->bindParam(":experience", $this->experience);
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
            $query = "UPDATE " . $this->table . " SET first_name= :first_name, last_name= :last_name, phone= :phone, email = :email WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":degree", $this->degree);
            $stmt->bindParam(":experience", $this->experience);
            $stmt->bindParam(":img", $this->img);
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
