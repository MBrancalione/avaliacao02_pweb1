<?php
include './headerUsuario.php';
include '../login/autenticacao.php';
include_once "../db.class.php";

$db = new db('usuario');

if (isset($_SESSION['usuario_id'])) {
    $id = $_SESSION['usuario_id'];
} else {
    header('Location: ../login/login.php');
    exit;
}

if (!empty($_GET['id_delete'])) {
    if ($_GET['id_delete'] == $id) {
        $db->destroi($_GET['id_delete']);
        session_destroy();
        header('Location: ../../index.php');
        exit;
    }
}

$dados = $db->getUser($id);

// Se os dados vierem como um único objeto, envelopa em um array para o loop
if ($dados && !is_array($dados)) {
    $dados = [$dados];
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: var(--lilas, #4c32a8); letter-spacing: -0.5px;">Minha Conta</h3>
                <p class="text-muted small">Gerencie suas informações de acesso e perfil na Bibi TV</p>
            </div>

            <?php if (!empty($dados)): foreach ($dados as $item): ?>
                
                <div class="card shadow border-0 rounded-4 overflow-hidden mb-4" style="background: #ffffff;">
                    
                    <div style="height: 100px; background: linear-gradient(135deg, var(--lilas, #4c32a8), var(--lilas-hover, #745ccc));"></div>
                    
                    <div class="card-body px-4 pb-4 position-relative">
                        
                        <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center text-white fw-bold" 
                             style="width: 80px; height: 80px; background-color: var(--amarelopastel, #fbd28c); color: var(--lilas, #4c32a8) !important; font-size: 2rem; border: 4px solid #ffffff; position: absolute; top: -40px; left: 24px;">
                            <?= strtoupper(substr(htmlspecialchars($item->nome), 0, 1)) ?>
                        </div>

                        <div style="height: 45px;"></div>

                        <div class="mb-4">
                            <h4 class="fw-bold text-dark m-0"><?= htmlspecialchars($item->nome) ?></h4>
                            <span class="text-muted small">ID do Usuário: #<?= htmlspecialchars($item->id) ?></span>
                        </div>

                        <hr class="text-black-50 my-3">

                        <div class="d-flex flex-column gap-3 my-4">
                            
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #f1f3f9;">
                                    <i class="fi fi-rr-envelope text-muted" style="font-size: 1.1rem; line-height: 1;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">E-mail cadastrado</small>
                                    <strong class="text-dark"><?= htmlspecialchars($item->email) ?></strong>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #f1f3f9;">
                                    <i class="fi fi-rr-phone-call text-muted" style="font-size: 1.1rem; line-height: 1;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Telefone / Celular</small>
                                    <strong class="text-dark"><?= htmlspecialchars($item->telefone ?? 'Não informado') ?></strong>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #f1f3f9;">
                                    <i class="fi fi-rr-user text-muted" style="font-size: 1.1rem; line-height: 1;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Nome de Usuário (Login)</small>
                                    <strong class="text-dark"><?= htmlspecialchars($item->login) ?></strong>
                                </div>
                            </div>

                        </div>

                        <hr class="text-black-50 my-3">

                        <div class="d-flex flex-row-reverse justify-content-between m-3 pt-2">
                            <a class="btn fw-bold px-4 py-2 border-0 text-dark" 
                               style="background-color: var(--amarelopastel, #fbd28c); transition: all 0.2s;" 
                               href="../login/cadastro.php?id=<?= $id ?>">Editar Perfil
                            </a>

                            <a class="btn btn-link btn-sm text-danger text-decoration-none fw-semibold align-self-center ms-2" 
                               onclick="return confirm('Tem certeza absoluta 2que deseja deletar a sua conta? Esta ação não pode ser desfeita.')" 
                               href="?id_delete=<?= $id ?>">
                                Excluir Conta
                            </a>
                        </div>

                    </div>
                </div>

            <?php endforeach; else: ?>
                <div class="alert alert-warning text-center rounded-3 shadow-sm" role="alert">
                    Nenhum dado encontrado para a sua conta.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
include '../../footer.php';
?>