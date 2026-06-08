<?php
include '..\header.php';
//include '../login/autenticacao.php';
include_once "./db.class.php";

$db = new db('catalogo');

if (!empty($_GET['id'])) {
    $db->destroi($_GET['id']);
    $dados = $db->all(); 
}

if (!empty($_POST['valor'])) {
    $dados = $db->search($_POST); 
} else {
    $dados = $db->all();
} 
?>

<div class="row">
    <h3>Catalogo</h3>
    <form action="catalogoList.php" method="post">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Buscar por:</label>
                <select name="tipo" class="form-select">
                    <option value="id">ID</option>
                    <option value="titulo">Título</option>
                    <option value="genero">Genero</option>
                    <option value="faixa_etaria">Faixa Etaria</option>
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
        <a href="insertCatalogo.php" class="btn btn-success">Novo Item no Catalogo</a>
    </div>
</div>

<div class="row">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Título</th>
                    <th scope="col">Sinopse</th>
                    <th scope="col">Ano de Lançamento</th>
                    <th scope="col">Elenco</th>
                    <th scope="col">Genero</th>
                    <th scope="col" colspan="2" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dados as $item) {
                    echo "<tr>
                    <th scope='row'>$item->id</th>
                    <td>$item->titulo</td>
                    <td>$item->sinopse</td>
                    <td>$item->ano_lançamento</td>
                    <td>$item->elenco</td>
                    <td>$item->genero</td>
                    <td class='text-center'>
                        <a class='btn btn-warning btn-sm' title='Editar' href='insertCatalogo.php?id=$item->id'>Editar</a>
                    </td>   
                    <td class='text-center'>
                        <a class='btn btn-danger btn-sm' title='Deletar' onclick='return confirm(\"Tem certeza que deseja deletar este usuário?\")' href='catalogoList.php?id=$item->id'>Deletar</a>
                    </td>   
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '..\footer.php';
?>