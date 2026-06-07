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
</div>

<?php
include '../footer.php';
?>