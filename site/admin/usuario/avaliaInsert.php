<?php
include './headerUsuario.php';
include '../login/autenticacao.php';
include_once "../db.class.php";

$db = new db('avaliacao');
$success = '';
$actionError = '';
$errors = [];
$data = null;

$db_catalogo = new db('catalogo');
$catalogofilmes = $db_catalogo->all();

if (isset($_SESSION['usuario_id'])) {
    $id = $_SESSION['usuario_id'];
}

if(!empty($_GET['id'])) {  
    $data = $db->find($_GET['id']);
} 

if (!empty($_POST['id_catalogo'])) {
    $filme_id = intval($_POST['id_catalogo']);
} elseif (!empty($data->id_catalogo)) {
    $filme_id = $data->id_catalogo;
} elseif (!empty($_GET['id_catalogo'])) {
    $filme_id = intval($_GET['id_catalogo']);
} else {
    $errors[] = "Operação inválida: Nenhum filme foi selecionado para avaliação.";
    $filme_id = 0;
}

if (!empty($_POST)) {
    $data = (object) $_POST; 
    try {
        if (empty($errors)) {
            if(empty($_POST['id'])) {
                unset($_POST['id']);
                $dado = [
                    'id_usuario'  => $id,          
                    'id_catalogo' => $filme_id,    
                    'nota'        => $_POST['nota'],    
                    'comentario'  => $_POST['comentario'], 
                    'spoiler'     => $_POST['spoiler']   
                ];

                $db->store($dado);
                $success = "Avaliação salva com sucesso!";
            } else {
                $db->update($_POST); 
                $success = "Avaliação atualizada com sucesso!";
            }

            redirect('avaliaList.php', 1200);
        }
    } catch (PDOException $e) {
        $actionError = $e->getMessage();
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}
?>

<?php
    function redirect($page, $time = 500){
        echo "<script>setTimeout(()=>window.location.href='$page', '$time')</script>";
    }

    function actionMessage($success, $error){
        if(!empty($success)){
            echo "<div class='alert alert-success rounded-3 shadow-sm' role='alert'><i class='fi fi-rr-check-circle me-2'></i>$success</div>";
        }
        if(!empty($error)){
            echo "<div class='alert alert-danger rounded-3 shadow-sm' role='alert'><i class='fi fi-rr-cross-circle me-2'></i>$error</div>";
        }
    }

    function showValidationError($errors = []) {
        if (!empty($errors)) {
            echo "<div class='alert alert-danger rounded-3 shadow-sm' role='alert'><ul>";
            echo "<strong>Erros nos campos:</strong>";
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>"; 
            }
            echo "</ul></div>";
        }
    }   

    function getFormValue($data, $field='') {
        return isset($data->$field) ? $data->$field : '';
    }
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <?php actionMessage($success, $actionError) ?>
            <?php showValidationError($errors) ?>

            <div class="card shadow border-0 rounded-4 overflow-hidden" style="background: #ffffff;">
                
                <div class="d-flex align-items-center px-4" style="height: 100px; background: #4c32a8;">
                    <h4 class="fw-bold text-white m-0">
                        <?= !empty($_GET['id']) ? 'Editar Avaliação' : 'Nova Avaliação' ?>
                    </h4>
                </div>

                <div class="card-body p-4">
                    <?php if (empty($errors)): ?>
                        
                        <form action="./avaliaInsert.php" method="post">
                            
                            <input type="hidden" name="id" value="<?= getFormValue($data, 'id'); ?>"> 

                            <input type="hidden" name="id_catalogo" value="<?= $filme_id ?>"> 

                            <h4 class="mb-4">
                                <span class="text-muted small d-block fw-semibold mb-1">Filme:</span>
                                <span class="text-dark fw-bold">
                                    <?php 
                                    $tituloExibido = "Filme não encontrado";
                                    if (!empty($catalogofilmes)):
                                        foreach ($catalogofilmes as $itemFilme): 
                                            if ($itemFilme->id == $filme_id): 
                                                $tituloExibido = $itemFilme->titulo;
                                                break;
                                            endif;
                                        endforeach; 
                                    endif;
                                    echo htmlspecialchars($tituloExibido);
                                    ?>
                                </span>
                            </h4>

                            <div class="mb-4">
                                <label for="nota" class="form-label small fw-semibold text-muted">Sua Nota:</label>
                                <select name="nota" id="nota" class="form-select border-2 py-2 fw-bold" style="color: #ffc107;" required>
                                    <option value="" style="color: #000;">Escolha uma nota...</option>
                                    <?php 
                                    $notaAtual = getFormValue($data, 'nota');
                                    $opcoesNotas = [
                                        "5" => "★★★★★ (5 - Excelente)",
                                        "4" => "★★★★☆ (4 - Muito Bom)",
                                        "3" => "★★★☆☆ (3 - Regular)",
                                        "2" => "★★☆☆☆ (2 - Ruim)",
                                        "1" => "★☆☆☆☆ (1 - Péssimo)"
                                    ];
                                    foreach ($opcoesNotas as $valor => $texto):
                                        $selected = ($notaAtual == $valor) ? 'selected' : '';
                                        echo "<option value='{$valor}' {$selected} style='color: #212529;'>{$texto}</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="comentario" class="form-label small fw-semibold text-muted">Comentário:</label>
                                <textarea name="comentario" id="comentario" maxlength="600" rows="4" class="form-control border-2 p-3 text-secondary" placeholder="Deixe sua opinião sincera sobre a obra..." required><?= getFormValue($data, 'comentario'); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="spoiler" class="form-label small fw-semibold text-muted">Contém Spoiler?</label>
                                <select name="spoiler" id="spoiler" class="form-select border-2 py-2" required>
                                    <option value="">Selecione uma opção...</option>
                                    <?php $spoilerAtual = getFormValue($data, 'spoiler'); ?>
                                    <option value="1" <?= ($spoilerAtual == '1' || $spoilerAtual == 'Sim') ? 'selected' : '' ?>>Sim</option>
                                    <option value="0" <?= ($spoilerAtual == '0' || $spoilerAtual == 'Não') ? 'selected' : '' ?>>Não</option>
                                </select>
                            </div>

                            <hr class="text-black-50 my-4">

                            <div class="d-flex gap-2 justify-content-end align-items-center">
                                <a href="avaliaList.php" class="btn btn-link text-decoration-none fw-semibold text-muted me-2">
                                    Cancelar
                                </a>
                                
                                <button type="submit" class="btn fw-bold px-4 py-2 border-0 text-dark rounded-3" 
                                        style="background-color: var(--amarelopastel, #fbd28c); transition: all 0.2s;"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(251, 210, 140, 0.4)';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        Salvar Avaliação
                                </button>
                            </div>

                        </form>
                    
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted small">Por favor, volte à home e escolha um filme válido do catálogo para avaliar.</p>
                            <a href="avaliaList.php" class="btn btn-secondary fw-bold px-4 rounded-3 border-0">Voltar</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php
include '../../footer.php';
?>