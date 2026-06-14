<?php
include "./headerUsuario.php";
include '../login/autenticacao.php';
include_once "../db.class.php";

$db = new db('avaliacao');

if (!empty($_GET['id'])) {
    $db->destroi($_GET['id']);
    $dados = $db->all(); 
}

if (!empty($_POST['valor'])) {
    $dados = $db->search($_POST); 
} else {
    $dados = $db->all();
} 
?>

<div class="container my-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <h3 class="fw-bold" style="color: var(--lilas, #4c32a8); letter-spacing: -0.5px;">Minhas Avaliações</h3>
            <p class="text-muted small mb-0">Gerencie seus comentários e notas dos títulos da Bibi TV</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 mb-5" style="background: #ffffff;">
        <form action="avaliaList.php" method="post">
            <div class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted">Buscar por:</label>
                    <select name="tipo" class="form-select border-2">
                        <option value="nota" <?= isset($_POST['tipo']) && $_POST['tipo'] == 'nota' ? 'selected' : '' ?>>Nota</option>
                        <option value="genero" <?= isset($_POST['tipo']) && $_POST['tipo'] == 'genero' ? 'selected' : '' ?>>Filme</option>
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
                    <button type="submit" class="btn fw-bold text-dark w-100 border-0 py-2 rounded-3" 
                            style="background-color: var(--amarelopastel, #fbd28c); height: 41px;">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <?php if (!empty($dados)): foreach ($dados as $item): ?>
                
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4" style="background: #ffffff; border-left: 5px solid var(--lilas, #4c32a8) !important;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            
                            <div class="col-md-4 mb-3 mb-md-0">
                                <span class="text-muted d-block small fw-semibold mb-1">FILME / TÍTULO ID</span>
                                <h5 class="fw-bold text-dark mb-2">
                                    <i class="fi fi-rr-play-alt text-muted me-2" style="vertical-align: middle;"></i>#<?= htmlspecialchars($item->id_catalogo) ?>
                                </h5>
                                
                                <div class="d-inline-flex align-items-center gap-1 rounded-pill px-3 py-1 bg-light border">
                                    <i class="fi fi-rr-star text-warning small" style="line-height: 1;"></i>
                                    <span class="small fw-bold text-dark">Nota: <?= htmlspecialchars($item->nota) ?>/10</span>
                                </div>
                            </div>

                            <div class="col-md-5 mb-3 mb-md-0 border-start-md ps-md-4" style="border-color: #dee2e6;">
                                <span class="text-muted d-block small fw-semibold mb-1">COMENTÁRIO</span>
                                <p class="text-secondary small mb-2 italic">"<?= htmlspecialchars($item->comentario) ?>"</p>
                                
                                <?php if (strtolower($item->spoiler) == 'sim' || $item->spoiler == '1'): ?>
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-2 small" style="font-size: 0.75rem;">
                                        <i class="fi fi-rr-warning me-1"></i> Contém Spoiler
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-2 small" style="font-size: 0.75rem;">
                                        Livre de Spoilers
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-3 text-md-end">
                                <div class="d-flex d-md-block justify-content-end gap-2">
                                    
                                    <a class="btn btn-sm fw-bold px-3 py-2 border-0 text-dark rounded-3 me-md-2 mb-md-0" 
                                       style="background-color: var(--amarelopastel, #fbd28c); transition: all 0.2s;" 
                                       title="Editar Avaliação" 
                                       href="avaliaInsert.php?id=<?= $item->id ?>"
                                       onmouseover="this.style.transform='scale(1.05)'"
                                       onmouseout="this.style.transform='scale(1)'">
                                        <i class="fi fi-rr-edit"></i> Editar
                                    </a>

                                    <a class="btn btn-link btn-sm text-danger text-decoration-none fw-semibold align-self-center mt-md-2 d-md-block text-md-end" 
                                       title="Excluir Avaliação"
                                       onclick="return confirm('Tem certeza que deseja deletar esta avaliação?')" 
                                       href="avaliaList.php?id=<?= $item->id ?>">
                                        Excluir
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            <?php endforeach; else: ?>
                <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fi fi-rr-comment-alt text-muted" style="font-size: 1.5rem;"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Nenhuma avaliação por aqui</h5>
                    <p class="text-muted small">Suas avaliações pesquisadas ou cadastradas aparecerão nesta seção.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
include "../../footer.php";
?>