<?php
    if(session_status() == PHP_SESSION_NONE) { //se a sessão não tiver sido iniciada (none), inicia a sessão
        session_start();
    }

    if(!isset($_SESSION['usuario_id'])) { //se a variável de sessão 'usuario' não estiver definida, redireciona para a página de login
    alert('Faça login para acessar esta página.'); //exibe um alerta para o usuário    
    header('Location: ../login.php');
        exit; //garante que o código abaixo não seja executado após o redirecionamento
    }
?>

