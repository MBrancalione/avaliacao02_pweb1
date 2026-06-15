<?php
include './headerUsuario.php';
include '../login/autenticacao.php';
include_once '../db.class.php';

$db = new db('usuario');
$dbCatalogo = new db('catalogo');

// Processamento da Busca / Filtro Dinâmico
if (!empty($_POST['valor'])) {
    // Se o usuário selecionou um tipo no select, usamos ele. 
    // Caso contrário, define 'titulo' como o padrão de segurança.
    $_POST['tipo'] = !empty($_POST['tipo']) ? $_POST['tipo'] : 'titulo'; 
    
    $filmes = $dbCatalogo->search($_POST); 
} else {
    $filmes = $dbCatalogo->all();
}

$filmeAleatorio = null;
if (!empty($filmes)) {
    $chaveAleatoria = array_rand($filmes); 
    $filmeAleatorio = $filmes[$chaveAleatoria];
}

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
                        
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted">Buscar por:</label>
                            <select name="tipo" class="form-select border-2">
                                <option value="titulo" <?= isset($_POST['tipo']) && $_POST['tipo'] == 'titulo' ? 'selected' : '' ?>>Nome do Filme</option>
                                <option value="faixa_etaria" <?= isset($_POST['tipo']) && $_POST['tipo'] == 'faixa_etaria' ? 'selected' : '' ?>>Faixa Etária</option>
                                <option value="genero" <?= isset($_POST['tipo']) && $_POST['tipo'] == 'genero' ? 'selected' : '' ?>>Gênero</option>
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
                                Procurar
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 my-4">
                <h4 class="mb-3 fw-bold">Catálogo</h4>
                
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4 p-2 mb-4">
                    <?php if (!empty($filmes)):
                        foreach ($filmes as $filme): ?>

                            <div class="col">
                                <div class="d-flex align-items-end rounded shadow movie-card-scale position-relative" 
                                     style="height: 300px; background: linear-gradient(rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.9)), url('<?= htmlspecialchars($filme->url_poster) ?>'); background-size: cover; background-position: center;">
                                    
                                    <a href="<?= $filme->url_video ?>" class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;" title="Ver detalhes de <?= htmlspecialchars($filme->titulo) ?>"></a>

                                    <div class="container d-flex justify-content-center mb-2 position-absolute bottom-0 start-0 w-100 movie-buttons-container" style="z-index: 2;">
                                        <button class="btn text-white btn-movie-action" title="Comentar em <?= htmlspecialchars($filme->titulo) ?>">
                                            <a href="./avaliaInsert.php?id_catalogo=<?= $filme->id ?>" class="btn-link"><i class="fi fi-rr-comment" style="font-size: 24px;"></i></a>
                                        </button>
                                    </div>
                                </div>
                            </div>

                    <?php endforeach; 
                    else:
                        echo "<div class='col-12'><p class='text-muted ps-3'>Nenhum filme disponível no momento.</p></div>";
                    endif;?>
                </div>
            </div>

    </div>
</div>

<?php
include '../../footer.php';
?>