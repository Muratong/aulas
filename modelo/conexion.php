<?php 
class Conexion {
    private $host = 'localhost';
    private $db_name = 'aulas';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function Conectar() {
        $this->conn = null;

        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");

        return $this->conn;
    }
}