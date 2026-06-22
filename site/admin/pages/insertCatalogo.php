<?php
include './headerPages.php';
include '../login/autenticacao.php';

$db = new db('catalogo');
$success = '';
$actionError = '';
$errors = [];
$data = null;

// Função de segurança caso getFormValue não esteja definida em outro arquivo integrado
if (!function_exists('getFormValue')) { //se a função n existir
    function getFormValue($data, $field) {
        if (is_object($data) && isset($data->$field)) { //vê se o objeto existe e se tem o $data dentro dele
            return htmlspecialchars($data->$field);
        }
        if (is_array($data) && isset($data[$field])) { //mesma verificação, só que como array
            return htmlspecialchars($data[$field]);
        }
        return '';
    }
}

// confere se o id já existe
if(!empty($_GET['id'])) { 
    $data = $db->find($_GET['id']);
} 

if (!empty($_POST)) {
    $data = (object) $_POST; 
    
    try {
        if (empty($_POST['url_poster'])) $errors[] = "<li>O URL do pôster é obrigatório.</li>";
        if (empty($_POST['url_imagem_horizontal'])) $errors[] = "<li>O URL da imagem horizontal é obrigatório.</li>";
        if (empty($_POST['url_video'])) $errors[] = "<li>O URL do vídeo é obrigatório.</li>";
        if (empty($_POST['titulo'])) $errors[] = "<li>O título é obrigatório.</li>";
        if (empty($_POST['sinopse'])) $errors[] = "<li>A sinopse é obrigatória.</li>";
        if (empty($_POST['faixa_etaria'])) $errors[] = "<li>A faixa etária é obrigatória.</li>";
        if (empty($_POST['ano_lançamento'])) $errors[] = "<li>O ano de lançamento é obrigatório.</li>";
        if (empty($_POST['genero'])) $errors[] = "<li>O gênero é obrigatório.</li>";

        if (empty($errors)) {
            if(empty($_POST['id'])) {
                unset($_POST['id']);
                $db->store($_POST);
                $success = "Registro salvo com sucesso!"; //atribui uma msg p variavel
            } else {
                $db->update($_POST);
                $success = "Registro updated com sucesso!"; //atribui uma msg p variavel
            }
            
            $db->redirect('/avaliacao02_pweb1/site/admin/pages/listCatalogo.php');
            exit;
        }
    } catch (PDOException $e) { //erro banco
        $actionError = $e->getMessage();
    } catch (Exception $e) { //erro PHP
        $actionError = $e->getMessage();
    }
}

?>

<div class="container my-4 pb-5">
    
    <div class="mb-4">
        <h3 class="fw-bold text-dark">
            <?php echo !empty($_GET['id']) ? 'Editar Item do Catálogo' : 'Novo Item no Catálogo'; ?>
        </h3>
        <p class="text-muted small">Preencha os campos abaixo para gerenciar os títulos disponíveis na plataforma.</p>
    </div>

    <?php if (!empty($success)): ?> <!--verifica se a variavel $success esta vazia, se não estiver ele printa a msg de sucesso-->
        <div class="alert alert-success rounded-3 shadow-sm"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (!empty($actionError)): ?> <!--mesma coisa, só que com os actionError-->
        <div class="alert alert-danger rounded-3 shadow-sm"><?php echo $actionError; ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?> <!--mesma coisa, só que com os erros-->
        <div class="alert alert-warning rounded-3 shadow-sm">
            <ul class="mb-0 pt-1"><?php echo implode('', $errors); ?></ul> <!--implode pega todos os erros e junta em uma só string-->
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <form action="./insertCatalogo.php
            <?php echo !empty($_GET['id']) //verifica se tem id no endereço da pagina (função editar)
            ? '?id='.$_GET['id'] : ''; //se for vdd, ele coloca o id no final do diretório, se não ele não adiciona nada
            ?>" method="post">

            
            <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> <!--escondido do user, armazena o id. Pede se existe o id dentro da $data
                    se sim, ele atribui o valor do id em $data para o $id (isso para o modo edição)-->

            <div class="row g-3">
                
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Título da Mídia</label>
                    <input type="text" name="titulo" class="form-control border-2" placeholder="Ex: Sonic 3" value="<?php echo getFormValue($data, 'titulo'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Ano de Lançamento</label>
                    <input type="number" name="ano_lançamento" class="form-control border-2" placeholder="Ex: 2026" value="<?php echo getFormValue($data, 'ano_lançamento'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">URL do Pôster (Vertical - Miniatura)</label>
                    <input type="url" name="url_poster" class="form-control border-2" placeholder="https://link-da-imagem.com/poster-vertical.jpg" value="<?php echo getFormValue($data, 'url_poster'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">URL da Imagem Banner</label>
                    <input type="url" name="url_imagem_horizontal" class="form-control border-2" placeholder="https://link-da-imagem.com/banner-horizontal.jpg" value="<?php echo getFormValue($data, 'url_imagem_horizontal'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">URL do Vídeo (Trailer/Filme)</label>
                    <input type="url" name="url_video" class="form-control border-2" placeholder="https://link-do-video.com/player" value="<?php echo getFormValue($data, 'url_video'); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Faixa Etária</label>
                    <?php $faixaSelecionada = getFormValue($data, 'faixa_etaria'); ?>
                    <select name="faixa_etaria" class="form-select border-2">
                        <option value="">Selecionar Classificação</option>
                        <option value="L" <?php echo ($faixaSelecionada == 'L') ? 'selected' : ''; ?>>Livre</option> <!--verifica se já existe uma faixa seecionada, se sim, o selected deixa o item selecionado na tela-->
                        <option value="12" <?php echo ($faixaSelecionada == '12') ? 'selected' : ''; ?>>12 anos</option>
                        <option value="14" <?php echo ($faixaSelecionada == '14') ? 'selected' : ''; ?>>14 anos</option>
                        <option value="16" <?php echo ($faixaSelecionada == '16') ? 'selected' : ''; ?>>16 anos</option>
                        <option value="18" <?php echo ($faixaSelecionada == '18') ? 'selected' : ''; ?>>18 anos</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label small fw-semibold text-secondary">Gênero Principal</label>
                    <select name="genero" class="form-select border-2">
                        <option value="">Selecione um Gênero</option>
                        <?php 
                        $generos = ["Ação","Aventura","Cinema de arte","Chanchada","Comédia","Comédia de ação",
                                    "Comédia de terror","Comédia dramática","Comédia romântica","Dança",
                                    "Documentário","Docuficção","Drama","Espionagem","Faroeste","Fantasia",
                                    "Fantasia científica","Ficção científica","Filme épico","Filmes com truques",
                                    "Filmes de guerra","Filme policial","Mistério","Musical","Romance","Terror","Thriller"];
                        
                        $generoSelecionado = getFormValue($data, 'genero');
                        foreach ($generos as $genero) { //printagem das opções conforme a lista $generos
                            $selecionado = ($genero === $generoSelecionado) ? 'selected' : '';
                            echo "<option value=\"{$genero}\" {$selecionado}>{$genero}</option>"; //dentro do value tem que colocar essas contra barras para ele n fechar como string sem puxar o dado
                        }
                        ?>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold text-secondary">Sinopse</label>
                    <textarea name="sinopse" rows="4" maxlength="600" class="form-control border-2" placeholder="Escreva um breve resumo sobre a obra..."><?php echo getFormValue($data, 'sinopse'); ?></textarea>
                    <div class="form-text text-end small text-muted">Máximo de 600 caracteres.</div>
                </div>

                <div class="col-12 d-flex gap-2 mt-3">
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #4c32a8;">
                        Salvar Registro
                    </button>
                    <a href="listCatalogo.php" class="btn btn-light border px-4 fw-semibold text-secondary">
                        Cancelar e Voltar
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<div><div>
<?php
include '../../footer.php';
?>