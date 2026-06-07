<?php

class db
{
    //faz a conexão com o banco de dados local
    private $host     = 'localhost';
    private $user     = 'root';
    private $password = '';
    private $port     = '3306';
    private $dbname   = 'bibitv';
    private $table_name;
    private $conn; 

    //construtor da classe, recebe o nome da tabela e estabelece a conexão com o banco de dados
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->conn = $this->connect();
    }

    //método para estabelecer a conexão com o banco de dados usando PDO
    private function connect()
    {
        try {
            return new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=utf8",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }
}