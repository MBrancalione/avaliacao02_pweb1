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

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->conn = $this->connect();
    }

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

    //método para inserir dados na tabela, recebe um array associativo onde as chaves são os nomes dos campos e os valores são os dados a serem inseridos
    public function store($dados)
    {
        $campos = "";
        $marcadores = "";
        $vetorData = [];
        $sep = "";

        foreach ($dados as $campo => $valor) {
            $campos .= $sep . $campo; 
            $marcadores .= $sep . "?"; 
            $vetorData[] = $valor; //guarda os valores em um vetor para passar no execute
            $sep = ","; //após a primeira iteração, passa a ser ", " para separar os campos e marcadores
        }
                //concatenação dos dados que vem do banco para inserir no insert
        $sql = "INSERT INTO $this->table_name ($campos) VALUES ($marcadores);";
        try {
            $st = $this->conn->prepare($sql);
            $st->execute($vetorData);
        } catch (PDOException $e) {
            throw new Exception("Erro ao inserir: ". $e->getMessage());
        }
    }


    public function find($id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE id=?";
        $st = $this->conn->prepare($sql);
        $st->execute([$id]);

        return $st->fetchObject();
    }

    public function update($dados)
    {
        $campos = "";
        $marcadores = "";
        $vetorData = [];
        $sep = "";

        foreach ($dados as $campo => $valor) {
            if($campo !== 'id') {
            $campos .= $sep . " $campo = ?";
            $vetorData[] = $valor; 
            $sep = ", "; 
        }}
        $vetorData[] = $dados['id']; //adiciona o id no final do vetor para passar no execute
        $sql = "UPDATE $this->table_name SET $campos WHERE id = ?";

        try {
            $st = $this->conn->prepare($sql);
            $st->execute($vetorData);
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar: ". $e->getMessage());
        }
    }
    public function findBy($campo, $valor)
    {
        $sql = "SELECT * FROM $this->table_name WHERE $campo = ?";
        $st = $this->conn->prepare($sql);
        $st->execute([$valor]);

        return $st->fetchObject();
    }

    public function all()
    {
        $sql = "SELECT * FROM $this->table_name";
        $st = $this->conn->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUser($id) 
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = ?";
        $st = $this->conn->prepare($sql);
        $st->execute([$id]);

        return $st->fetchAll(PDO::FETCH_OBJ); //é oq faz retornar, se estiver vazio, retorna um array vazio, se tiver um registro, retorna um array com um objeto, se tiver mais de um registro, retorna um array com vários objetos
    }


    public function destroi($id)
    {
        $sql = "DELETE FROM $this->table_name WHERE id = ?";
        $st = $this->conn->prepare($sql);
        return $st->execute([$id]);
    }

    // Realiza buscas baseadas no filtro do formulário 
    public function search($post)
    {
        $campo = !empty($post['tipo']) ? $post['tipo'] : 'nome';
        $valor = !empty($post['valor']) ? $post['valor'] : '';

        $sql = "SELECT * FROM $this->table_name WHERE $campo LIKE ?";
        $st = $this->conn->prepare($sql);
        $st->execute(["%$valor%"]);

        return $st->fetchAll(PDO::FETCH_OBJ);
    }
   
    public  function redirect($page, $time = 500){
        echo "<script>setTimeout(()=>window.location.href='$page', '$time')</script>";
    }

    public function actionMessage($success, $error){
        if(!empty($success)){
            echo "<div class='alert alert-success' role='alert'>$success</div>";
        }
        if(!empty($error)){
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
    }
    


    public function showValidationError($errors = [])
    {
        if (!empty($errors)) {
            echo "<div class='alert alert-danger' role='alert'><ul>";
            echo "<strong>Erros nos campos:</strong>";
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>"; 
            }
            echo "</ul></div>";
        }
    }   

    //busca os dados no banco para o formulario quando ele está sendo editado
    public function getFormValue($data, $field='')
    {
        return isset($data->$field) ? $data->$field : '';
    }

    // Retorna a instância da conexão PDO para queries customizadas fora da classe
    public function getConn()
    {
        return $this->conn;
    }


    //Pesquisar item, problemas com acentos
    public function pesquisarItem($listaDeAtores, $termoDigitado, $campoDaBusca) { //Não consegui fazer isso sozinho, tentei mas deu erro. Pedi pro gemini ajuda
        if (empty($termoDigitado)) {
            return $listaDeAtores;
        }

        $limpador = Transliterator::create("Any-Latin; Latin-ASCII; Lower");
        $termoSemAcento = $limpador->transliterate($termoDigitado); 

        return array_filter($listaDeAtores, function($ator) use ($limpador, $termoSemAcento, $campoDaBusca) {
            $valorDoCampo = $ator->$campoDaBusca;
            $itemSemAcento = $limpador->transliterate($valorDoCampo);
            return str_contains($itemSemAcento, $termoSemAcento);
        });
    }
   
}

