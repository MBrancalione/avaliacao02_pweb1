<?php
include_once './headerUsuario.php';
include '../login/autenticacao.php';
include_once '../db.class.php';
?>

<div class="container">
    <div class="row">
        <div class="col-12 text-left py-2" style="background-color:">
            <h4 class="fw-bold mb-3" style="color: #4c32a8;">Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h4>
            <br>
        </div>
        <!--Foto banner no começo-->
    <div class="container-fluid d-flex align-items-end" style="height: 60vh; background: linear-gradient(rgba(255, 255, 255, 0.23), #ffffff), url('https://picsum.photos/1200');">
        <div class="container">
            <h1 class="display-3 fw-bold">Título do Filme</h1>
            <p class="lead w-50">Descrição breve do filme ou série destacada que aparece no banner principal da página inicial.</p>
            <button class="btn btn-light btn-lg px-4 me-2">Assistir</button>
            <button class="btn btn-secondary btn-lg px-4">Mais Informações</button>
            <br>
            <br>
            <br>
        </div>
    </div>

    <div class="col-12" style="background-color: white;">
        <br>
        <br>
        <h4>Ideia</h4>
        <div class="flex-row d-flex overflow-auto gap-3 p-3" style="scrollbar-width:none; min-width:300px; ">
            <div class="d-flex align-items-end"style="width: 200px; height: 300px; flex-shrink: 0; background: linear-gradient(rgba(255, 255, 255, 0) 40%, rgba(255, 255, 255, 0.9)), url('https://picsum.photos/200/300');">
                <div class="container d-flex justify-content-center">
                    <button class="btn"><i class="fi fi-rr-play" style="font-size: 26px;"></i></button>
                    <button class="btn"><i class="fi fi-rr-bookmark" style="font-size: 24px;"></i></button>
                </div>
                
            </div>
        </div>

        <div class="col-12 my-4">
            <h4 class="mb-3 fw-bold">Catálogo</h4>
            
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4">
                
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                <div class="col">
                    <div class="movie-card">
                        <img src="https://picsum.photos/300/450" class="img-fluid movie-img" alt="Filme 1">
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>
<script src="https://jsdelivr.net"></script>

<?php
include_once '../../footer.php';
?>