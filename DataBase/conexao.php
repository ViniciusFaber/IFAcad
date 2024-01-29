<?php
class Conexao {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        $this->host = "localhost";
        $this->dbname = "db_ifacad";
        $this->username = "";//login do seu banco de dados
        $this->password = "";//senha do seu banco de dados
    }

    public function conectar() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            // Tratar erros de conexão
            echo 'Erro de conexão com o banco de dados: ' . $e->getMessage();
            exit();
        }
    }

    public function fecharConexao() {
        $this->conn = null;
    }
}

 
?>
