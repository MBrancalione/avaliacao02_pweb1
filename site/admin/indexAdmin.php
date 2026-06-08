<?php
include '../header.php';
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

<div>
    <a href="./atorList.php">Atores</a>
    <a href="./catalogoList.php">Catálogo</a>
    <a href="./planoList.php">Planos</a>
    <a href="./usuario/usuarioList.php">Usuarios</a>
</div>

<?php
include '../footer.php';
?>