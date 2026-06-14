<?php
include '..\..\header.php';
include '../login/autenticacao.php';
include_once "../db.class.php";

if($_SESSION['user_tipo'] !== 'admin') { 
    header('Location: ../login.php?erro=sem_permissao');
    exit; 
}

$db = new db('atores');

if (!empty($_GET['id'])) {
    $db->destroi($_GET['id']);
}
$dados = $db->all(); 

if (!empty($_POST['valor'])) {
    $termo = $_POST['valor'];
    $tipoCampo = $_POST['tipo'];
    
    //filtrar maiusculas, minusculas e acentos
    $dados = $db->pesquisarItem($dados, $termo, $tipoCampo);
}

?>

<div class="row">
    <h3>Listagem de Atores</h3>
    <form action="atorList.php" method="post">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Buscar por:</label>
                <select name="tipo" class="form-select">
                    <option value="nome_artista" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] === 'nome_artista') ? 'selected' : ''; ?>>Nome</option>  <!--Serve para manter o item selecionado no select-form-->
                    <option value="nacionalidade" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] === 'nacionalidade') ? 'selected' : ''; ?>>País de Origem</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Inserir termo para busca:</label>
                <input type="text" name="valor" placeholder="Valor da busca" class="form-control" value="<?php echo isset($_POST['valor']) ? $_POST['valor'] : ''; ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 mb-1">Buscar</button>
            </div>
        </div>
    </form>
    <div class="mb-3">
        <a href="insertAtor.php" class="btn btn-success">Novo Ator</a>
    </div>
</div>

<div class="row">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Data de Nascimento</th>
                    <th scope="col">Nacionalidade</th>
                    <th scope="col" colspan="2" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dados as $item) {
                    echo "<tr>
                    <th scope='row'>$item->id</th>
                    <td>$item->nome_artista</td>
                    <td>$item->data_nascimento</td>
                    <td>$item->nacionalidade</td>
                    <td class='text-center'>
                        <a class='btn btn-warning btn-sm' title='Editar' href='insertAtor.php?id=$item->id'>Editar</a>
                    </td>   
                    <td class='text-center'>
                        <a class='btn btn-danger btn-sm' title='Deletar' onclick='return confirm(\"Tem certeza que deseja deletar este usuário?\")' href='atorList.php?id=$item->id'>Deletar</a>
                    </td>   
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '..\..\footer.php';
?>