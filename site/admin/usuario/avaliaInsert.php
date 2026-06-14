<?php
include '../../header.php';
include '../login/autenticacao.php';
include_once "../db.class.php";

$db = new db('avaliacao');
$success = '';
$actionError = '';
$errors = [];
$data = '';


$filme_id = isset($_GET['filme_id']) ? $_GET['filme_id'] : null;
$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

if(!empty($_GET['id'])) {  
    $data = $db->find($_GET['id']);
} 

if (!empty($_POST)) {

    $data = (object) $_POST; 
    try {
        if (empty($errors)) {
            if(empty($_POST['id'])) {
                unset($_POST['id']);
                $dado = [
                    'id_usuario' => $usuario_id,      // Salvando quem é o usuário logado
                    'id_catalogo'   => $filme_id,        // Salvando quem é o filme
                    'nota'       => $_POST['nota'],    // Salvando a nota digitada
                    'comentario' => $_POST['comentario'] // Salvando o texto digitado
                    'spoiler'    => $_POST['spoiler']   // Salvando se tem spoiler ou não
                ];

                $db->store($dado);
                $success = "Registro Salvo com sucesso!";
            }
            else {
        // Atualização
        $db->update($_POST); // Passa o $_POST (array), já que a sua função espera só um parâmetro!
        $success = "Registro Atualizado com sucesso!";
    }
            $success = "Registro Salvo com sucesso!";

            redirect('avaliaList.php');
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

    <form action="./insertAvaliacao.php" method="post">
        <h3>Formulário AVALIAÇÃO</h3>

        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 

        <div class="col-6">
            <label for="nota" class="form-label fw-medium">Sua Nota:</label>
            <select name="nota" id="nota" class="form-select form-select-lg" style="color: #ffc107; font-weight: bold;">
                <option value="" style="color: #000;">Escolha uma nota...</option>
                <option value="5">★★★★★ (5 - Excelente)</option>
                <option value="4">★★★★☆ (4 - Muito Bom)</option>
                <option value="3">★★★☆☆ (3 - Regular)</option>
                <option value="2">★★☆☆☆ (2 - Ruim)</option>
                <option value="1">★☆☆☆☆ (1 - Péssimo)</option>
            </select>
        </div>
        <div class="col-6">
            <label for="sinopse">Comentário</label>
            <input type="text"  maxlength="600" name="sinopse" class="form-control" value="<?php echo getFormValue($data, 'comentario'); ?>">
        </div>
        <div class="col-6">
            <label for="spoiler" class="form-label fw-medium">Contém Spoiler?</label>
            <select name="spoiler" id="spoiler" class="form-select form-select-lg">
                <option value="" style="color: #000;">Selecione uma opção...</option>
                <option value="1">Sim</option>
                <option value="0">Não</option>
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
include '../../footer.php';
?>