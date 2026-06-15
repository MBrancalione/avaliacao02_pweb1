<?php
include './login/autenticacao.php';
include_once "./db.class.php";

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = '';

if(session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

if(!isset($_SESSION['usuario_id'])) {
    $db->redirect('/avaliacao02_pweb1/site/admin/login/login.php');
    exit;
}

if((int)$_SESSION['usuario_tipo'] !== 2) { 
    $db->redirect('/avaliacao02_pweb1/site/admin/usuario/indexUsuario.php?erro=sem_permissao');
    exit; 
}

include '../header.php';
?>

<div class="container my-5 pb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm p-4 text-white" style="background: linear-gradient(135deg, #4c32a8, #745ccc);">
                <div class="d-md-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold mb-1">
                            Olá, Admin <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!!!
                        </h2>
                        <p class="m-0 text-white-50 lead fs-6">Bem-vindo de volta ao centro de controle da Bibi TV.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card h-100 border-2 rounded-4 shadow-sm border-light bg-white p-3 text-center" style="transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Conteúdo</div>
                        <h5 class="fw-bold text-dark mb-2">
                            <i class="bi bi-film me-2" style="color: #4c32a8;"></i>Catálogo de Mídias
                        </h5>
                        <p class="text-muted small mt-2">Controle de filmes, séries, vídeos ativos e suas respectivas categorias.</p>
                    </div>
                    <a href="./pages/listCatalogo.php" class="btn btn-sm text-white w-100 py-2 mt-2 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #4c32a8;">
                        <span>Gerenciar Catálogo</span> &rarr;
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-2 rounded-4 shadow-sm border-light bg-white p-3 text-center" style="transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Financeiro</div>
                        <h5 class="fw-bold text-dark mb-2">
                            <i class="bi bi-card-list me-2" style="color: #4c32a8;"></i>Planos de Assinatura
                        </h5>
                        <p class="text-muted small mt-2">Configuração de preços, vigências, vantagens e planos premium do sistema.</p>
                    </div>
                    <a href="./pages/listPlano.php" class="btn btn-sm text-white w-100 py-2 mt-2 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #4c32a8;">
                        <span>Gerenciar Planos</span> &rarr;
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-2 rounded-4 shadow-sm border-light bg-white p-3 text-center" style="transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Segurança</div>
                        <h5 class="fw-bold text-dark mb-2">
                            <i class="bi bi-people me-2" style="color: #4c32a8;"></i>Controle de Usuários
                        </h5>
                        <p class="text-muted small mt-2">Administração de perfis de clientes, níveis de acesso e contas registradas.</p>
                    </div>
                    <a href="./usuario/listUsuario.php" class="btn btn-sm text-white w-100 py-2 mt-2 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #4c32a8;">
                        <span>Gerenciar Perfis</span> &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<div><div>
<?php
include '../footer.php';
?>