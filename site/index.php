<?php
include_once './header.php';
include_once './admin/db.class.php';

$conn = new db('usuario');

// Se quiser que esse usuário seja inserido toda vez que a página carregar, mantenha o código abaixo.
// Caso contrário, você pode apagar esse bloco de dados e o store.
$dados = [
    'nome' => 'Ryan',
    'telefone' => '123456789',
    'email' => 'ryan@example.com',
    'login' => 'admin',
    'senha' => password_hash('123456', PASSWORD_DEFAULT),   
    'tipo' => '2'
];

// Comentado para evitar inserções duplicadas toda vez que atualizar a Home. 
// Se precisar rodar o teste, basta tirar as duas barras da linha abaixo:
// $conn->store($dados);
?>

<div class="col-12 text-center py-5">
    <h1 class="display-4 fw-bold mb-3" style="color: #4c32a8;">Bem-vindo à Bibi TV</h1>
    <p class="lead text-muted mb-5">Sua plataforma favorita de vídeos e conteúdos interativos.</p>
    
    <div class="d-flex justify-content-center gap-3">
        <a href="./admin/login/login.php" class="btn btn-primary btn-lg px-4" style="background-color: #4c32a8; border-color: #4c32a8;">Acessar Login</a>
        <a href="./admin/login/cadastro.php" class="btn btn-outline-secondary btn-lg px-4">Criar uma Conta</a>
    </div>
</div>

<?php
include_once './footer.php';
?>