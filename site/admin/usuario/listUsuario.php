<?php
include '../login/autenticacao.php';
include '../pages/headerPages.php';

$db = new db('usuario');

if (!empty($_GET['id'])) {
    $db->destroi($_GET['id']);
    $db->redirect('/avaliacao02_pweb1/site/admin/usuario/listUsuario.php');
    exit;
}

if (!empty($_POST['valor'])) {
    $dados = $db->search($_POST); 
} else {
    $dados = $db->all();
} 

?>

<div class="container my-4 pb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 p-2">
        <h3 class="fw-bold text-dark m-0">
            Controle de Usuários
        </h3>
        <a href="../login/cadastro.php" class="btn text-white btn-sm px-3 fw-bold d-inline-flex align-items-center gap-1" style="background-color: #4c32a8;">
            Novo Usuário
        </a>
    </div>

    <form action="listUsuario.php" method="post" class="bg-white p-3 rounded-4 shadow-sm border border-light mb-4">
        <div class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted">Buscar por:</label>
                <select name="tipo" class="form-select border-2">
                    <option value="nome" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'nome') ? 'selected' : 'all'; ?> selected>Nome</option>
                    <option value="telefone" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'telefone') ? 'selected' : ''; ?>>Telefone</option>
                    <option value="email" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'email') ? 'selected' : ''; ?>>Email</option>
                    <option value="login" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'login') ? 'selected' : ''; ?>>Login</option>
                    <option value="tipo" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'tipo') ? 'selected' : ''; ?>>Tipo</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-muted">Inserir termo para busca:</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-search text-muted"></i></span>
                    <input type="text" name="valor" placeholder="O que você está procurando?" class="form-control border-2 border-start-0" value="<?php echo isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-warning fw-bold text-dark w-100 border-0" style="padding: 0.6rem 0;">Filtrar Usuários</button>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="table-light">
                    <tr class="text-secondary small fw-bold">
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Contato / Telefone</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Login</th>
                        <th scope="col" class="text-center" style="width: 130px;">Nível</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dados)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted small">Nenhum usuário encontrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dados as $item): ?>
                            <tr>
                                <th scope="row" class="fw-bold text-secondary"><?php echo $item->id; ?></th>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($item->nome); ?></td>
                                <td class="text-secondary small"><?php echo htmlspecialchars($item->telefone); ?></td>
                                <td class="text-secondary small"><?php echo htmlspecialchars($item->email); ?></td>
                                <td class="text-secondary small"><?php echo htmlspecialchars($item->login); ?></td>                                
                                
                                <td class="text-center small">
                                    <?php if ($item->tipo == 2): //compara o item q ele puxa do banco com o vaor q eu coloquei (2), que seria o admin ?>
                                        <span class="badge rounded-pill px-2 py-1 small fw-bold" style="background-color: #4c32a8; color: #fff;">2</span>
                                    <?php else: ?>
                                        <span class="badge text-secondary px-2 py-1 small fw-bold">1</span>
                                    <?php endif; ?>
                                </td>  
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div><div>
<?php
include '../../footer.php';
?>