<?php
include './headerUsuario.php';
include '../login/autenticacao.php';
include_once '../db.class.php';

$db = new db('usuario');
$dbCatalogo = new db('catalogo');

// Retorna todos os registros cadastrados
$filmes = $dbCatalogo->all();

// Sorteia um filme aleatório para o banner de destaque
$filmeAleatorio = null;
if (!empty($filmes)) {
    $chaveAleatoria = array_rand($filmes); 
    $filmeAleatorio = $filmes[$chaveAleatoria];
}

// Cria uma cópia isolada para a seção horizontal "O que acha desses?"
$filmesAleatorios = $filmes;
?>

    <div class="container my-4">
        <div class="row">
            <div class="col-12 text-left py-2">
                <h3 class="fw-bold mb-3" style="color: var(--lilas);">Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']); ?>!</h3>
            </div>
            
            <?php if ($filmeAleatorio): ?>
            <div class="container-fluid d-flex align-items-end rounded shadow mb-5" style="height: 60vh; background: linear-gradient(rgba(0, 0, 0, 0.2), #141414), url('<?= htmlspecialchars($filmeAleatorio->url_imagem_horizontal) ?>'); background-size: cover; background-position: center;">
                <div class="container text-white pb-4 ps-4">
                    <h1 class="display-3 fw-bold"><?= htmlspecialchars($filmeAleatorio->titulo) ?></h1>
                    <p class="lead w-50 text-light"><?= htmlspecialchars($filmeAleatorio->sinopse) ?></p>
                    <a href="<?= $filmeAleatorio->url_video ?>" class="btn btn-light btn-lg px-4 me-2 fw-bold">Assistir</a>
                    <a href="https://www.google.com/search?q=<?= urlencode($filmeAleatorio->titulo) ?>" target="_blank" class="btn btn-secondary btn-lg px-4 text-white" style="background-color: rgba(255,255,255,0.2); border: none;">Mais Informações</a>                </div>
            </div>
            <?php endif; ?>

            <div class="col-12 mb-4">
                <h4 class="fw-bold">O que acha desses?</h4>
                <div class="flex-row d-flex overflow-auto gap-3 p-3" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <?php 
                    if (!empty($filmesAleatorios)):
                        shuffle($filmesAleatorios); // Embaralha de forma independente
                        foreach ($filmesAleatorios as $filme): 
                    ?>
                            <div class="d-flex align-items-end rounded shadow movie-card-scale position-relative" 
                                 style="width: 200px; min-width: 200px; height: 300px; flex-shrink: 0; background: linear-gradient(rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.9)), url('<?= htmlspecialchars($filme->url_poster) ?>'); background-size: cover; background-position: center;">
                                
                                <a href="<?= $filme->url_video ?>" class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;" title="Ver detalhes de <?= htmlspecialchars($filme->titulo) ?>"></a>

                                <div class="container d-flex justify-content-center mb-2 position-absolute bottom-0 start-0 w-100 movie-buttons-container" style="z-index: 2;">
                                    <button class="btn text-white btn-movie-action" title="Comentar em <?= htmlspecialchars($filme->titulo) ?>">
                                        <a href="./avaliaInsert.php?id_catalogo=<?= $filme->id ?>" class="btn-link"><i class="fi fi-rr-comment" style="font-size: 24px;"></i></a>
                                    </button>
                                </div>
                            </div>
                    <?php 
                        endforeach; 
                    else:
                        echo "<p class='text-muted ps-3'>Nenhum filme disponível no momento.</p>";
                    endif;
                    ?>
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