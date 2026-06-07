<?php
include_once './admin/db.class.php';

//instaciar um objeto da classe DB
$conn = new db('usuario');

/* inserção de dados manualmente
$dados = [
    'nome' => 'Ryan',
    'telefone' => '123456789',
    'email' => 'ryan@example.com',
    'login' => 'user',
    'senha' => '123',
    'tipo' => '2'
];

$conn->store($dados);*/
echo "Você está no index caralho"; ?>

<div>
    <a href="./admin/login/login.php">Login</a>
    <a href="./admin/login/cadastro.php">Cadastro</a>
</div>