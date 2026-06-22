<?php
include './headerPages.php';
include '../login/autenticacao.php';

$db = new db('plano');

if (!empty($_GET['id'])) {
    $db->destroi($_GET['id']);
}
$dados = $db->all(); 

if (!empty($_POST['valor'])) {
    $termo = $_POST['valor'];
    $tipoCampo = $_POST['tipo']; 

    $dados = $db->pesquisarItem($dados, $termo, $tipoCampo);
    }
?>
<div class="container my-4 pb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 p-2">
        <h3 class="fw-bold text-dark m-0">
            Planos de Assinatura
        </h3>
        <a href="insertPlano.php" class="btn text-white btn-sm px-3 fw-bold d-inline-flex align-items-center gap-1" style="background-color: #4c32a8;">
            Novo Plano
        </a>
    </div>

    <form action="listPlano.php" method="post" class="bg-white p-3 rounded-4 shadow-sm border border-light mb-4">
        <div class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted">Buscar por:</label>
                <select name="tipo" class="form-select border-2">
                    <option value="nome_plano" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'nome_plano') ? 'selected' : ''; ?> selected>Nome do Plano</option> <!--o cmapo tipo foi enviado via form? & o valor selcionado pelo usuario é igual o nome do plano?-->
                    <option value="preco_mensal" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'preco_mensal') ? 'selected' : ''; ?>>Preço Mensal</option>
                    <option value="id" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'id') ? 'selected' : ''; ?>>ID</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-muted">Inserir termo para busca:</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-search text-muted"></i></span>
                    <input type="text" name="valor" placeholder="O que você está procurando?" class="form-control border-2 border-start-0" value="<?php echo isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : ''; ?>"> <!-- Campo e busca. lógica: o usuario já fez uma busca e enviou o form antes? 
                                                                                                                                                                                                                                    Se sim, ele pega e coloca o texto inserido de volta no campo-->
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-warning fw-bold text-dark w-100 border-0" style="padding: 0.6rem 0;">Filtrar Planos</button>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="table-light">
                    <tr class="text-secondary small fw-bold">
                        <th scope="col" style="width: 60px;">#</th>
                        <th scope="col">Nome do Plano</th>
                        <th scope="col">Preço Mensal</th>
                        <th scope="col" class="text-center">Limite de Telas</th>
                        <th scope="col">Resolução Máxima</th>
                        <th scope="col" class="text-center" style="width: 140px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dados)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted small">Nenhum plano encontrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dados as $item): ?> <!--percorre os dados e armazena em $item-->
                            <tr>
                                <th scope="row" class="fw-bold text-secondary"><?php echo $item->id; ?></th>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($item->nome_plano); ?></td>
                                <td class="text-success fw-semibold">
                                    R$ <?php echo number_format((float)$item->preco_mensal, 2, ',', '.'); ?> <!-- QUantas casas decimais, separador de centavos, separador de milhares-->
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <?php echo htmlspecialchars($item->limite_telas); ?> tela(s)
                                    </span>
                                </td>
                                <td class="text-secondary small"><?php echo htmlspecialchars($item->resolucao_max); ?></td>
                                
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a class="btn btn-light border btn-sm text-dark" title="Editar" href="insertPlano.php?id=<?php echo $item->id; ?>">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <!--botao deletar-->
                                        <a class="btn btn-outline-danger btn-sm" title="Deletar" 
                                           onclick="return confirm('Tem certeza que deseja deletar este plano de assinatura?')" 
                                           href="listPlano.php?id=<?php echo $item->id; ?>">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>   
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php
include '..\..\footer.php';
?>