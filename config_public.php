<?php
session_start();
# Preencha a base com a url base da sua aplicação
$base = "";



class Config {
    # Preencha com as informações do seu banco de dados
    private $db_name = "";
    private $db_host = "";
    private $db_user = "";
    private $db_pass = "";
    private $conn;
    public function __construct(){
        try {
            $conn = new PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
           } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getConn(){
        return $this->conn;
    }
}
