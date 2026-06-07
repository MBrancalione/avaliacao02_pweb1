<?php   
session_start(); //inicia a sessão para acessar as variáveis de sessão
session_destroy(); //destroi a sessão, ou seja, remove todas as variáveis de sessão e encerra a sessão atual
header('Location: ../../index.php'); //redireciona para a página de login
?>