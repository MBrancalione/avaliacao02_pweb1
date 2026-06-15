<?php
include '../login/autenticacao.php';
include './headerPages.php';

$db = new db('catalogo');

if (!empty($_GET['id'])) {
    $db->destroi($_GET['id']);
    $db->redirect('/avaliacao02_pweb1/site/admin/pages/listCatalogo.php');
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
        <h3 class="fw-bold text-dark m-0">Catálogo</h3>
        <a href="insertCatalogo.php" class="btn text-white btn-sm px-3 fw-bold d-inline-flex align-items-center gap-1" style="background-color: #4c32a8;">Novo Item
        </a>
    </div>

    <form action="listCatalogo.php" method="post" class="bg-white p-3 rounded-4 shadow-sm border border-light mb-4">
        <div class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted">Buscar por:</label>
                <select name="tipo" class="form-select border-2">
                    <option value="id" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'id') ? 'selected' : ''; ?>>ID</option>
                    <option value="titulo" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'titulo') ? 'selected' : 'all'; ?> selected>Título</option>
                    <option value="genero" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'genero') ? 'selected' : ''; ?>>Gênero</option>
                    <option value="faixa_etaria" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'faixa_etaria') ? 'selected' : ''; ?>>Faixa Etária</option>
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
                <button type="submit" class="btn btn-warning fw-bold text-dark w-100 border-0" style="padding: 0.6rem 0;">Filtrar Catálogo</button>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="table-light">
                    <tr class="text-secondary small fw-bold">
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col" style="width: 90px;">Poster</th>
                        <th scope="col">Título</th>
                        <th scope="col" class="d-none d-md-table-cell" style="max-width: 300px;">Sinopse</th>
                        <th scope="col">Ano</th>
                        <th scope="col">Gênero</th>
                        <th scope="col">Faixa Etária</th>
                        <th scope="col" class="text-center" style="width: 140px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dados)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted small">Nenhum item encontrado no catálogo.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dados as $item): ?>
                            <tr>
                                <th scope="row" class="fw-bold text-secondary"><?php echo $item->id; ?></th>
                                <td>
                                    <?php if (!empty($item->url_poster)): ?>
                                        <img src="<?php echo htmlspecialchars($item->url_poster); ?>" alt="Poster" class="rounded shadow-sm" style="width: 50px; height: 70px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 50px; height: 70px; font-size: 0.7rem;">Sem foto</div>
                                    <?php endif; ?>
                                </td>

                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($item->titulo); ?></td>
                                <td class="text-muted small d-none d-md-table-cell text-truncate" style="max-width: 300px;"><?php echo htmlspecialchars($item->sinopse); ?></td>
                                <td class="text-secondary small"><?php echo htmlspecialchars($item->ano_lançamento); ?></td>
                                <td class="text-secondary small"><?php echo htmlspecialchars($item->genero); ?></td>
                                <td class="text-secondary small text-center"><?php echo htmlspecialchars($item->faixa_etaria); ?></td>


                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a class="btn btn-light border btn-sm text-dark" title="Editar" href="insertCatalogo.php?id=<?php echo $item->id; ?>">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm" title="Deletar" 
                                           onclick="return confirm('Tem certeza que deseja deletar este item do catálogo?')" 
                                           href="listCatalogo.php?id=<?php echo $item->id; ?>">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
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