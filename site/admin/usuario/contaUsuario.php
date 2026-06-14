<?php
include './headerUsuario.php';
include '../login/autenticacao.php';
include_once "../db.class.php";

$db = new db('usuario');
if (isset($_SESSION['usuario_id'])) {
    $id = $_SESSION['usuario_id'];
}

if (!empty($_GET['id_delete'])) {
    if($_GET['id_delete'] == $id) {
        $db->destroi($_GET['id_delete']);
        session_destroy();
        header('Location: ../../index.php');
        exit;
    }
}

$dados = $db->getUser($id);



?>
<div class="row">
    <h3>Minha Conta</h3>
<div class="row">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Login</th>
                    <th scope="col" colspan="2" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dados as $item) {
                    echo "<tr>
                    <th scope='row'>$item->id</th>
                    <td>$item->nome</td>
                    <td>$item->telefone</td> 
                    <td>$item->email</td>
                    <td>$item->login</td>
                    <td class='text-center'>
                        <a class='btn btn-warning btn-sm' title='Editar' href='../login/cadastro.php?id=$id'>Editar</a>
                    </td>   
                    <td class='text-center'>
                        <a class='btn btn-danger btn-sm' title='Deletar' onclick='return confirm(\"Tem certeza que deseja deletar este usuário?\")' href='?id_delete=$id'>Deletar</a>
                    </td>   
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include '../../footer.php';
?>