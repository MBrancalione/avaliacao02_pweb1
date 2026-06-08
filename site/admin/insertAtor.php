<?php
include '../header.php';
include_once "./db.class.php";

$db = new db('atores');
$success = '';
$actionError = '';
$errors = [];
$data = '';

//if(session_status() == PHP_SESSION_NONE) { session_start(); }
//if(!isset($_SESSION['usuario_id'])) {
//    header('Location: ../login.php');
//    exit;
//}
//if($_SESSION['usuario_tipo'] !== 2) { 
//  header('Location: ../index.php?erro=sem_permissao');
//    exit; 
//}




if(!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {

    $data = (object) $_POST; //converte o array associativo do post para um objeto para facilitar o acesso aos campos
    // var_dump($_POST);
    //exit;
    try {

        //coloquei para definirmos o id pq ele está dando algum erro referente as chaves, ver isso.
        if (empty($_POST['id'])) {
            $errors[] = "<li>O id do artista é obrigatório</li>";
        }

        if (empty($_POST['nome_artista'])) {
            $errors[] = "<li>O nome do artista é obrigatório</li>";
        }

        if (empty($_POST['data_nascimento'])) {
            $errors[] = "<li>O email é obrigatório</li>";
        }

        if (empty($_POST['nacionalidade'])) {
            $errors[] = "<li>A nacionalidade é obrigatório</li>";
        }

        if (empty($errors)) {
            if(empty($_POST['id'])) {
                //o código está enviando um id vazio para o banco, se não existir um id, ele deve ser retirado, para que então seja possível ao banco inserir automaticamente
                unset($_POST['id']);

                $db->store($_POST);
                $success = "Registro Salvo com sucesso!";
            }
            $success = "Registro Salvo com sucesso!";

            redirect('index.php');
        }
    } catch (PDOException $e) {
        $actionError = $e->getMessage();
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}


?>

<div class="row">
    <?php actionMessage($success, $actionError) ?>
    <?php showValidationError($errors) ?>

    <form action="./insertAtor.php" method="post">
        <h3>Formulário INSERT ATOR</h3>

        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 

        <div class="col-6">
            <label for="id">ID</label>
            <input type="int" name="id" class="form-control" value="<?php echo getFormValue($data, 'id'); ?>">
        </div>
        <div class="col-6">
            <label for="nome_artista">Nome</label>
            <input type="text" name="nome_artista" class="form-control" value="<?php echo getFormValue($data, 'nome_artista'); ?>">
        </div>
        <div class="col-6">
            <label for="data_nascimento">Data de Nascimento</label>
            <input type="date" name="data_nascimento" class="form-control" value="<?php echo getFormValue($data, 'data_nascimento'); ?>">
        </div>
        <div class="col-6">
            <label for="nacionalidade">nacionalidade</label>
            <input type="text" name="nacionalidade" class="form-control" value="<?php echo getFormValue($data, 'nacionalidade'); ?>">
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="index.php" class="btn btn-primary"> Voltar</a>
        </div>
</div>


    </form>

</div>


<?php
include '../footer.php';
?>