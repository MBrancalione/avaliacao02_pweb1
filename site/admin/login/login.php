<?php
include 'headerLogin.php';

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = '';

if(session_status() == PHP_SESSION_NONE) { 
        session_start();
}

if (!empty($_POST)){ //verifica se o formulário foi submetido
    $data = (object) $_POST; //converte o array associativo do POST para um objeto para facilitar o acesso aos dados

    //validação dos campos de login e senha para garantir que não estejam vazios
    try{
        if (empty($_POST['login'])){
            $errors[] = "O campo login é obrigatório.";
        }
        if (empty($_POST['senha'])){
            $errors[] = "O campo senha é obrigatório.";
        }
    

        if(empty($errors)){
            $usuario = $db->findBy('login', $_POST['login']); //busca o usuário no banco de dados pelo login fornecido
            if($usuario && password_verify($_POST['senha'], $usuario->senha)){ //verifica se o usuário existe e se a senha está correta
                $_SESSION['usuario_id'] = $usuario->id; //armazena o ID do usuário na sessão para manter o estado de login
                $_SESSION['usuario_login'] = $usuario->login; 
                $_SESSION['usuario_nome'] = $usuario->nome;
                $_SESSION['usuario_tipo'] = $usuario->tipo;
                $success = "Login bem-sucedido! Redirecionando para o painel...";
                
                if ($_SESSION['usuario_tipo'] == 2) {
                    $db->redirect('/avaliacao02_pweb1/site/admin/indexAdmin.php', 1000); 
                } else {
                    $db->redirect('/avaliacao02_pweb1/site/admin/usuario/indexUsuario.php', 1000); 
                }
                exit;
            }
        }
    } catch (PDOException $e){
        $actionError = $e->getMessage();
    } catch (PDOException $e){
        $actionError = $e->getMessage();
    }
}
?>
<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            
            <?php $db->actionMessage($success, $actionError); ?>
            <?php $db->showValidationError($errors); ?>

            <div class="card shadow border-0 rounded-4 overflow-hidden" style="background: #ffffff;">
                
                <div class="d-flex align-items-center justify-content-center px-4" style="height: 90px; background: #4c32a8 ">
                    <h5 class="fw-bold text-white m-0">
                        Acesso ao Sistema
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="" method="POST"> 
                        
                        <div class="mb-3">
                            <label for="login" class="form-label small fw-semibold text-muted">Login</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-user text-muted"></i></span>
                                <input type="text" class="form-control border-2 border-start-0 text-secondary" id="login" name="login" placeholder="Seu usuário" value="<?php echo $db->getFormValue($data, 'login'); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="senha" class="form-label small fw-semibold text-muted">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-key text-muted"></i></span>
                                <input type="password" class="form-control border-2 border-start-0 text-secondary" id="senha" name="senha" placeholder="••••••••">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn fw-bold text-dark w-100 border-0 py-2 rounded-3 mt-2" 
                                style="background-color: #fbd28c;">Entrar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include '../../footer.php'?>