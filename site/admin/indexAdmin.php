<?php
include '../header.php';
include '../login/autenticacao.php';
include_once "./db.class.php";

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = '';

if(session_status() == PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}
if($_SESSION['usuario_tipo'] !== 2) { 
    header('Location: ../index.php?erro=sem_permissao');
    exit; 
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Bem-vindo ao painel de administração, <?php echo $_SESSION['usuario_nome']; ?>!</h2>
            <p>Aqui você pode gerenciar o catálogo de filmes, planos de assinatura e usuários do sistema.</p>
        </div>
    </div>
<?php
include '../footer.php';
?>