<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="./admin/categoria/css/styles.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php
include './admin/db.class.php';
$conn = new db('usuario');
$adminExistente = $conn->findBy('tipo', '2');
$dados = [
    'nome'     => 'João',
    'telefone' => '123456789',
    'email'    => 'joao@example.com',
    'login'    => 'admin',
    'senha'    => password_hash('123456', PASSWORD_DEFAULT),
    'tipo'     => '2'
];
if (!$adminExistente) {
    $conn->store($dados);
} else {
}
?> 

    <div class="carousel-container">
        <div class="texto-fixo-overlay">
            <div class="card shadow border-0 rounded-4 overflow-hidden" style="background-color:rgba(255, 255, 255, 0.83)">
                <div class="card-body p-5">
                    <h1 class="display-4 fw-bold mb-3" style="color: #4c32a8;">Bem-vindo à Bibi TV</h1>
                    <p class="lead text-muted mb-5">Sua plataforma favorita de vídeos e conteúdos interativos.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="./admin/login/login.php" class="btn btn-primary btn-lg px-4" style="background-color: #4c32a8; border-color: #4c32a8;">Acessar Login</a><br>
                        <a href="./admin/login/cadastro.php" class="btn btn-outline-secondary btn-lg px-4">Criar uma Conta</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carrossel -->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://admin.cnnbrasil.com.br/wp-content/uploads/sites/12/2024/04/o-menino-maluquinho-filme.png?w=1200&h=675&crop=1" class="d-block w-100" alt="Primeiro Slide">
                </div>
                <div class="carousel-item">
                    <img src="https://bubblegeek.com.br/media/o-verdadeiro-nome-do-chaves.webp" class="d-block w-100" alt="Segundo Slide">
                </div>
                <div class="carousel-item">
                    <img src="https://occ-0-8407-2219.1.nflxso.net/dnm/api/v6/6AYY37jfdO6hpXcMjf9Yu5cnmO0/AAAABfzhocnO_OhjXKkwQJqVEEUm1gmSLpGP4MHNrPFPnhVcnjqmSJfJCZrLpmISMkROESKf004aKR1I4eZNUfT2UE_9D7yHrUREr1G_.jpg?r=2ad" class="d-block w-100" alt="Terceiro Slide">
                </div>
                <div class="carousel-item">
                    <img src="https://conteudo.imguol.com.br/c/entretenimento/d8/2017/09/27/bob-esponja-1506562776988_v2_900x506.jpg" class="d-block w-100" alt="Quarto Slide">
                </div>
            </div>
        </div>
    </div>

<?php
include_once './footer.php';
?>