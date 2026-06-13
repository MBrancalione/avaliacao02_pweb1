<?php
include '../header.php';
include_once "./db.class.php";

$db = new db('planos');
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

        if (empty($_POST['nome_plano'])) {
            $errors[] = "<li>O nome do plano é obrigatório</li>";
        }

        if (empty($_POST['preco_mensal'])) {
            $errors[] = "<li>O email é obrigatório</li>";
        }

        if (empty($_POST['limite_telas'])) {
            $errors[] = "<li>O limite de telas é obrigatório</li>";
        }

        if (empty($_POST['resolucao_max'])) {
            $errors[] = "<li>A resolucao max é obrigatório</li>";
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

            redirect('planoList.php');
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

    <form action="./insertPlano.php" method="post">
        <h3>Formulário INSERT PLANO</h3>

        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 

        <div class="col-6">
            <label for="nome_plano">Nome</label>
            <input type="text" name="nome_plano" class="form-control" value="<?php echo getFormValue($data, 'nome_plano'); ?>">
        </div>
        <div class="col-6">
            <label for="preco_mensal">Preço Mensal (R$)</label>
            <input type="int" name="preco_mensal" class="form-control" value="<?php echo getFormValue($data, 'preco_mensal'); ?>">
        </div>
        <div class="col-6">
            <label for="limite_telas">limite de telas</label>
            <input type="int" name="limite_telas" class="form-control" value="<?php echo getFormValue($data, 'limite_telas'); ?>">
        </div>
        <div class="col-6">
            <label for="resolucao_max">Resoluçao Máxima</label>
            <select name="resolucao_max" class="form-select"> 
                <option value="">Selecione a Resolução</option>
                <?php
                    //mesma ideia utilizada no insertAtor.php
                    $resolucoes = ["HD (720p)", "Full HD (FHD / 1080p)", "Quad HD (QHD / 2K / 1440p)", "Ultra HD (UHD / 4K)", "8K (UHD)"];
                    
                    $resolucaoSelecionada = getFormValue($data, 'resolucao_max'); 
                    
                    foreach ($resolucoes as $resolucao) {
                        $selecionado = ($resolucao === $resolucaoSelecionada) ? 'selected' : '';
                        echo "<option value=\"{$resolucao}\" {$selecionado}>{$resolucao}</option>";
                    }
                    ?>
            </select>
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