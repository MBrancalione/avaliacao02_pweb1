<?php
include './headerUsuario.php';
include '../login/autenticacao.php';
include_once '../db.class.php';

$db = new db('usuario');
$dbCatalogo = new db('catalogo');

// Processamento da Busca / Filtro por Título
if (!empty($_POST['valor'])) {
    // Tratamento para manter compatibilidade com o método search() da sua classe db
    // Ajustado para buscar pelo campo 'titulo' do catálogo
    $_POST['tipo'] = 'titulo'; 
    $filmes = $dbCatalogo->search($_POST); 
} else {
    // Se não houver busca, traz todos os registros ordinários
    $filmes = $dbCatalogo->all();
}

// Sorteia um filme aleatório para o banner de destaque (Apenas se houver registros)
$filmeAleatorio = null;
if (!empty($filmes)) {
    $chaveAleatoria = array_rand($filmes); 
    $filmeAleatorio = $filmes[$chaveAleatoria];
}

// Cria uma cópia independente para a esteira horizontal "O que acha desses?"
$filmesAleatorios = $filmes;
?>

<div class="container my-4">
    <div class="row">

        <div class="row align-items-center mb-4">
            <div class="col-md-12 text-center text-md-middle mb-3 mb-md-0">
                <br>
                <h3 class="fw-bold" style="color: var(--lilas, #4c32a8); letter-spacing: -0.5px;">Catálogo</h3>
            </div>
        </div>

        <div class="col-12 mb-5">
            <div class="card shadow-sm border-0 rounded-4 p-4" style="background: #ffffff;">
                <form action="catalogoUsuario.php" method="post">
                    <div class="row align-items-end g-3">
                        <div class="col-md-9">
                            <label class="form-label small fw-semibold text-muted">Pesquisar filme ou série no catálogo:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-search text-muted"></i></span>
                                <input type="text" name="valor" placeholder="Digite o título do filme..." class="form-control border-2 border-start-0" value="<?php echo isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn fw-bold text-dark w-100 border-0 py-2 rounded-3" 
                                    style="background-color: var(--amarelopastel, #fbd28c); height: 41px;">
                                Procurar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 my-2">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold text-dark m-0">Catálogo Completo</h4>
                </div>
                <?php if (!empty($_POST['valor'])): ?>
                    <a href="catalogoUsuario.php" class="btn btn-sm btn-outline-secondary rounded-3 px-3">Limpar Filtro</a>
                <?php endif; ?>
            </div>
            
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4 p-2 mb-4">
                <?php if (!empty($filmes)): foreach ($filmes as $filme): ?>

                    <div class="col">
                        <div class="d-flex align-items-end rounded shadow movie-card-scale position-relative" 
                             style="height: 280px; background: linear-gradient(rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.9)), url('<?= htmlspecialchars($filme->url_poster) ?>'); background-size: cover; background-position: center;">
                            
                            <a href="detalhes.php?id=<?= $filme->id ?>" class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;" title="Ver detalhes de <?= htmlspecialchars($filme->titulo) ?>"></a>

                            <div class="container d-flex justify-content-center mb-2 position-absolute bottom-0 start-0 w-100 movie-buttons-container" style="z-index: 2;">
                                <button class="btn text-white btn-movie-action" title="Comentar em <?= htmlspecialchars($filme->titulo) ?>">
                                    <a href="./avaliaInsert.php" class="btn-link"><i class="fi fi-rr-comment" style="font-size: 24px;"></i></a>
                                </button>
                            </div>
                        </div>
                    </div>

                <?php endforeach; else: ?>
                    <div class="col-12 text-center py-5 w-100 bg-white rounded-4 shadow-sm p-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fi fi-rr-search-alt text-muted" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Nenhum título encontrado</h5>
                        <p class="text-muted small">Não encontramos resultados correspondentes para "<strong><?= htmlspecialchars($_POST['valor']) ?></strong>". Verifique a grafia ou tente outro termo.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php
include '../../footer.php';
?>