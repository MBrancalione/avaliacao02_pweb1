<?php
include_once './admin/db.class.php';

//instaciar um objeto da classe DB
$conn = new db('usuario');

$dados = [
    'nome' => 'João',
    'telefone' => '123456789',
    'email' => 'joao@example.com',
    'login' => 'joao_user',
    'senha' => 'senha123',
    'tipo' => '1'
];

$conn->store($dados);
echo "Você está no index caralho";