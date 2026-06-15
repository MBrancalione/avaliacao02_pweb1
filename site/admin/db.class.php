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

    //método para inserir dados na tabela, recebe um array associativo onde as chaves são os nomes dos campos e os valores são os dados a serem inseridos
    public function store($dados)
    {
        $campos = "";
        $marcadores = "";
        $vetorData = [];
        $sep = "";

        foreach ($dados as $campo => $valor) {
            $campos .= $sep . $campo; //campo1, campo2, campo3
            $marcadores .= $sep . "?"; //?, ?, ?
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
            $campos .= $sep . " $campo = ?"; //?, ?, ?
            $vetorData[] = $valor; //guarda os valores em um vetor para passar no execute
            $sep = ", "; //após a primeira iteração, passa a ser ", " para separar os campos e marcadores
        }}
        $vetorData[] = $dados['id']; //adiciona o id no final do vetor para passar no execute
                //concatenação dos dados que vem do banco para inserir no insert
        $sql = "UPDATE $this->table_name SET $campos WHERE id = ?";

        try {
            $st = $this->conn->prepare($sql);
            $st->execute($vetorData);
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar: ". $e->getMessage());
        }
    }
    //método para buscar um registro na tabela com base em um campo específico, recebe o nome do campo e o valor a ser buscado
    public function findBy($campo, $valor)
    {
        $sql = "SELECT * FROM $this->table_name WHERE $campo = ?";
        $st = $this->conn->prepare($sql);
        $st->execute([$valor]);

        return $st->fetchObject();
    }

    // Retorna todos os registros da tabela
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


    // Deleta um registro pelo ID
    public function destroi($id)
    {
        $sql = "DELETE FROM $this->table_name WHERE id = ?";
        $st = $this->conn->prepare($sql);
        return $st->execute([$id]);
    }

    // Realiza buscas baseadas no filtro do formulário (tipo e valor)
    public function search($post)
    {
        $campo = !empty($post['tipo']) ? $post['tipo'] : 'nome';
        $valor = !empty($post['valor']) ? $post['valor'] : '';

        $sql = "SELECT * FROM $this->table_name WHERE $campo LIKE ?";
        $st = $this->conn->prepare($sql);
        $st->execute(["%$valor%"]);

        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    public function pesquisarItem($listaDeAtores, $termoDigitado, $campoDaBusca) { //Não consegui fazer isso sozinho, tentei mas deu erro. Pedi pro gemini ajuda
        if (empty($termoDigitado)) {
            return $listaDeAtores;
        }

        // Criamos a ferramenta que remove acentos e joga para minúsculo
        $limpador = Transliterator::create("Any-Latin; Latin-ASCII; Lower");

        // Mudamos o termo digitado usando a ferramenta
        $termoSemAcento = $limpador->transliterate($termoDigitado); 

        return array_filter($listaDeAtores, function($ator) use ($limpador, $termoSemAcento, $campoDaBusca) {
            $valorDoCampo = $ator->$campoDaBusca;
            
            // Mudamos o valor do banco usando a ferramenta
            $itemSemAcento = $limpador->transliterate($valorDoCampo);
            
            // CORRIGIDO: Agora compara o item do banco com o termo digitado!
            return str_contains($itemSemAcento, $termoSemAcento);
        });
    }
   
   
   
    /*tempo padrão para o redirecoinamento nas páginas */
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

    public function getFormValue($data, $field='')
    {
        return isset($data->$field) ? $data->$field : '';
    }

    // Retorna a instância da conexão PDO para queries customizadas fora da classe
    public function getConn()
    {
        return $this->conn;
    }

}

