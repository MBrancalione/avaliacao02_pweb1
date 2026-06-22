<?php
include './headerPages.php';
include '../login/autenticacao.php';

$db = new db('plano');
$success = '';
$actionError = '';
$errors = [];
$data = null;

if (!function_exists('getFormValue')) {
    function getFormValue($data, $field) {
        if (is_object($data) && isset($data->$field)) {
            return htmlspecialchars($data->$field);
        }
        if (is_array($data) && isset($data[$field])) {
            return htmlspecialchars($data[$field]);
        }
        return '';
    }
}

if(!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    $data = (object) $_POST; 
    
    try {
        if (empty($_POST['nome_plano'])) {
            $errors[] = "<li>O nome do plano é obrigatório.</li>";
        }

        if (empty($_POST['preco_mensal'])) {
            $errors[] = "<li>O preço mensal é obrigatório.</li>";
        }

        if (empty($_POST['limite_telas'])) {
            $errors[] = "<li>O limite de telas é obrigatório.</li>";
        }

        if (empty($_POST['resolucao_max'])) {
            $errors[] = "<li>A resolução máxima é obrigatória.</li>";
        }

        if (empty($errors)) { 
            if(empty($_POST['id'])) {
                unset($_POST['id']);
                $db->store($_POST);
                $success = "Registro salvo com sucesso!";
            } else {
                $db->update($_POST); 
                $success = "Registro atualizado com sucesso!";
            }

            $db->redirect('/avaliacao02_pweb1/site/admin/pages/listPlano.php');
            exit;
        }
    } catch (PDOException $e) {
        $actionError = $e->getMessage();
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}

?>

<div class="container my-4 pb-5">
    
    <div class="mb-4">
        <h3 class="fw-bold text-dark">
            <?php echo !empty($_GET['id']) ? 'Editar Plano de Assinatura' : 'Novo Plano de Assinatura'; ?>
        </h3>
        <p class="text-muted small">Gerencie as opções de planos de assinatura, preços e limitações técnicas da plataforma.</p>
    </div>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success rounded-3 shadow-sm"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (!empty($actionError)): ?>
        <div class="alert alert-danger rounded-3 shadow-sm"><?php echo $actionError; ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-warning rounded-3 shadow-sm">
            <ul class="mb-0 pt-1"><?php echo implode('', $errors); ?></ul>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <form action="./insertPlano.php<?php echo !empty($_GET['id']) ? '?id='.$_GET['id'] : ''; ?>" method="post"> <!--verifica se já existe esse id no url (func editar), se não ele não coloca nada -->
            
            <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> <!--armazena o id, função editar-->

            <div class="row g-3">
                
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Nome do Plano</label>
                    <input type="text" name="nome_plano" class="form-control border-2" placeholder="Ex: Premium 4K" value="<?php echo getFormValue($data, 'nome_plano'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Preço Mensal (R$)</label>
                    <input type="float" name="preco_mensal" class="form-control border-2" placeholder="Ex: 45.90" value="<?php echo getFormValue($data, 'preco_mensal'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Limite de Telas</label>
                    <input type="number" name="limite_telas" class="form-control border-2" placeholder="Ex: 4" value="<?php echo getFormValue($data, 'limite_telas'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Resolução Máxima</label>
                    <select name="resolucao_max" class="form-select border-2"> 
                        <option value="">Selecione a Resolução</option>
                        <?php
                        $resolucoes = ["HD (720p)", "Full HD (FHD / 1080p)", "Quad HD (QHD / 2K / 1440p)", "Ultra HD (UHD / 4K)", "8K (UHD)"]; //array
                        $resolucaoSelecionada = getFormValue($data, 'resolucao_max'); //vê qual res estava salva ou foi enviada no form
                        
                        foreach ($resolucoes as $resolucao) { // percore a lista de resoluções e salva em $resolucao a cada loop
                            $selecionado = ($resolucao === $resolucaoSelecionada) ? 'selected' : ''; // ve se a resolução seleciondada é igual a ue estava antes
                            echo "<option value=\"{$resolucao}\" {$selecionado}>{$resolucao}</option>";// / -> caractere de escape
                        }
                        ?>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 mt-4">
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #4c32a8;">
                        Salvar Plano
                    </button>
                    <a href="listPlano.php" class="btn btn-light border px-4 fw-semibold text-secondary">
                        Cancelar e Voltar
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

<div><div>
<?php
include '../../footer.php';
?>