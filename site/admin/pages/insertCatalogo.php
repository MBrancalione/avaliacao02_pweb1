<?php
include '../../header.php';
include '../login/autenticacao.php';
include_once "../db.class.php";

if($_SESSION['user_tipo'] !== 'admin') { 
    header('Location: ../login.php?erro=sem_permissao');
    exit; 
}
$db = new db('catalogo');
$success = '';
$actionError = '';
$errors = [];
$data = '';

//joga para o login se a pessoa n estiver logada

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

        if (empty($_POST['url_poster'])) {
            $errors[] = "<li>O url do poster é obrigatório</li>";
        }

        if (empty($_POST['url_video'])) {
            $errors[] = "<li>O url do video é obrigatório</li>";
        }

        if (empty($_POST['titulo'])) {
            $errors[] = "<li>O titulo é obrigatório</li>";
        }

        if (empty($_POST['sinopse'])) {
            $errors[] = "<li>A sinopse é obrigatório</li>";
        }

        if (empty($_POST['faixa_etaria'])) {
            $errors[] = "<li>O faixa etaria é obrigatório</li>";
        }

        if (empty($_POST['ano_lançamento'])) {
            $errors[] = "<li>O ano do lançamento é obrigatório</li>";
        }

        if (empty($_POST['elenco'])) {
            $errors[] = "<li>O elenco é obrigatório</li>";
        }

        if (empty($_POST['genero'])) {
            $errors[] = "<li>O genero é obrigatório</li>";
        }

        if (empty($errors)) {
            if(empty($_POST['id'])) {
                //o código está enviando um id vazio para o banco, se não existir um id, ele deve ser retirado, para que então seja possível ao banco inserir automaticamente
                unset($_POST['id']);

                $db->store($_POST);
                $success = "Registro Salvo com sucesso!";
            }
            else {
        // Atualização
        $db->update($_POST); // Passa o $_POST (array), já que a sua função espera só um parâmetro!
        $success = "Registro Atualizado com sucesso!";
    }
            $success = "Registro Salvo com sucesso!";

            redirect('catalogoList.php');
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

    <form action="./insertCatalogo.php" method="post">
        <h3>Formulário ITEM CATALOGO</h3>

        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 

        <div class="col-6">
            <label for="url">URL do Poster</label>
            <input type="text" name="url_poster" class="form-control" value="<?php echo getFormValue($data, 'url_poster'); ?>">
        </div>

        <div class="col-6">
            <label for="url">URL do Video</label>
            <input type="text" name="url_video" class="form-control" value="<?php echo getFormValue($data, 'url_video'); ?>">
        </div>

        <div class="col-6">
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" class="form-control" value="<?php echo getFormValue($data, 'titulo'); ?>">
        </div>
        <div class="col-6">
            <label for="faixa_etaria">Faixa Etaria</label>
            <select name="faixa_etaria" class="form-select" value="<?php echo getFormValue($data, 'faixa_etaria'); ?>">
                <option value="">Selecionar Faixa Etaria</option>
                <option value="Livre">Livre</option>
                <option value="12">12</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
            </select>
        </div>
        <div class="col-6">
            <label for="ano_lançamento">Ano de Lançamento</label>
            <input type="int" name="ano_lançamento" class="form-control" value="<?php echo getFormValue($data, 'ano_lançamento'); ?>">
        </div>
        <div class="col-6">
            <label for="elenco">Atores Participantes</label>
            <a>Insira o ID</a>
            <input type="text" name="elenco" class="form-control"  value="<?php echo getFormValue($data, 'elenco'); ?>">

        </div>
        <div class="col-6">
            <label for="genero">Genero</label>
            <select type="int" name="genero" class="form-select">
                <option value="">Selecione um Gênero</option>
                <?php $generos = ["Ação","Aventura","Cinema de arte",
                                "Chanchada","Comédia","Comédia de ação",
                                "Comédia de terror","Comédia dramática","Comédia romântica","Dança",
                                "Documentário","Docuficção","Drama","Espionagem",
                                "Faroeste","Fantasia","Fantasia científica","Ficção científica",
                                "Filme épico","Filmes com truques","Filmes de guerra",
                                "Filme policial","Mistério","Musical",
                                "Romance","Terror","Thriller"];
                    
                    $generoSelecionado = getFormValue($data, 'genero');

                    foreach ($generos as $genero) {
                        $selecionado = ($genero === $generoSelecionado) ? 'selected' : '';
                        echo "<option value=\"{$genero}\" {$selecionado}>{$genero}</option>";
                    }
                    
                ?>
            </select>
        </div>
        <div class="col-6">
            <label for="genero">Sinopse</label>
            <input type="text"  maxlength="600" name="sinopse" class="form-control" value="<?php echo getFormValue($data, 'sinopse'); ?>">
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="index.php" class="btn btn-primary"> Voltar</a>
        </div>

        <br>
        <br>
        <br>
       
</div>


    </form>

</div>


<?php
include '../../footer.php';
?>