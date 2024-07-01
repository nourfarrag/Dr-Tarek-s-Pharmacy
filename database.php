<?php

class Database {
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $pdo;

    public function __construct($host, $user, $pass, $name) {
        $this->db_host = $host;
        $this->db_user = $user;
        $this->db_pass = $pass;
        $this->db_name = $name;

        try {
            $this->pdo = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name, $this->db_user, $this->db_pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
