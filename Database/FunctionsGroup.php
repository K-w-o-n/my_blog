<?php

namespace Database;

use PDOException;

class FunctionsGroup{

    private $db = null;

    public function __construct(MySQL $db) {

        $this->db = $db->connect();
    }

    public function insert($data) {

        try {
            
            $sql = "INSERT INTO articles (title, description, photo, created_at) VALUES (:title, :description, :photo, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);

            return $this->db->lastInsertId();

        } catch (PDOException $e) {
            
            return $e->getMessage();
        }
    }

    public function getAll() {
        
        $stmt = $this->db->query("SELECT * FROM articles");

        return $stmt->fetchAll();
    }

    public function register($email,$password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:email, password=:email");

        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);

        $row = $stmt->fetch();

        return $row ?? false;
    }

}