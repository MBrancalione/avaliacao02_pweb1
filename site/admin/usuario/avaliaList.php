<?php
include "./headerUsuario.php";
include '../login/autenticacao.php';
include_once "../db.class.php";

$db = new db('avaliacao');

$db_catalogo = new db('catalogo');
$catalogofilmes = $db_catalogo->all();

if (!empty($_GET['id'])) {
    $db->destroi($_GET['id']);
    $dados = $db->all(); 
}

if (!empty($_POST['valor'])) {
    $tipo = $_POST['tipo'] ?? 'nota';
    $valor = $_POST['valor'];

    if ($tipo === 'titulo') {
        //Não da para mexer em duas tabelas ao mesmo tempo usando as funções, dai tem que fazer a funcao em forma de sql
        //INNER JOIN deixa mexer em duas tabelas ao mesmo tempo, "juntar" elas
        $sql = "SELECT a.* FROM avaliacao a 
                INNER JOIN catalogo c ON a.id_catalogo = c.id 
                WHERE c.titulo LIKE ? ORDER BY a.id DESC";
        
        $stmt = $db->getConn()->prepare($sql); // Utiliza a conexão ativa da classe db
        $stmt->execute(["%$valor%"]);
        $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        $dados = $db->search($_POST); 
    }
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
                        <option value="titulo" <?= isset($_POST['tipo']) && $_POST['tipo'] == 'titulo' ? 'selected' : '' ?>>Filme</option>
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
                
                <?php 
                $nomeFilme = "Filme não encontrado";
                $urlPoster = ""; // Variável para armazenar a imagem
                
                if (!empty($catalogofilmes)): //printagem por laco
                    foreach ($catalogofilmes as $itemFilme): 
                        if ($itemFilme->id == $item->id_catalogo): 
                            $nomeFilme = $itemFilme->titulo;
                            $urlPoster = $itemFilme->url_poster; 
                            break; 
                        endif;
                    endforeach; 
                endif;
                ?>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4" style="background: #ffffff;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            
                            <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                                <?php if (!empty($urlPoster)): ?>
                                    <img src="<?= htmlspecialchars($urlPoster) ?>" alt="Poster de <?= htmlspecialchars($nomeFilme) ?>" class="rounded-3 shadow-sm img-fluid" style="max-height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border mx-auto mx-md-0" style="width: 85px; height: 120px; font-size: 0.75rem;">Sem Foto</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-3 mb-3 mb-md-0">
                                <span class="text-muted d-block small fw-semibold mb-1">FILME</span>
                                <h5 class="fw-bold text-dark mb-2">
                                    <?= htmlspecialchars($nomeFilme); ?>
                                </h5>
                                
                                <div class="d-inline-flex align-items-center gap-1 rounded-pill px-3 py-1 bg-light border">
                                    <i class="fi fi-rr-star text-warning small" style="line-height: 1;"></i>
                                    <span class="small fw-bold text-dark">Nota: <?= htmlspecialchars($item->nota) ?>/5</span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3 mb-md-0 border-start-md ps-md-4" style="border-color: #dee2e6;">
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
                                <div class="d-flex justify-content-center justify-content-md-end gap-2">
                                    <a class="btn btn-light border btn-sm text-dark px-3 py-2 rounded-3" title="Editar" href="avaliaInsert.php?id=<?php echo $item->id; ?>">
                                        <i class="bi bi-pencil me-1"></i> Editar
                                    </a>
                                    <a class="btn btn-outline-danger btn-sm px-3 py-2 rounded-3" title="Deletar" 
                                       onclick="return confirm('Tem certeza que deseja deletar esta avaliação?')" 
                                       href="avaliaList.php?id=<?php echo $item->id; ?>">
                                        <i class="bi bi-trash"></i>
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