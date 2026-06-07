<?php
    if(session_status() == PHP_SESSION_NONE) { //se a sessão não tiver sido iniciada (none), inicia a sessão
        session_start();
    }

    if(!isset($_SESSION['usuario_id'])) { //se a variável de sessão 'usuario' não estiver definida, redireciona para a página de login
        header('Location: ../login.php');
        exit; //garante que o código abaixo não seja executado após o redirecionamento
    }

/*<?php
if(session_status() == PHP_SESSION_NONE) { session_start(); }
// Só entra se for admin
if($_SESSION['user_tipo'] !== 'admin') { 
    header('Location: ../index.php?erro=sem_permissao');
    exit; 
}
?>*/
?>

