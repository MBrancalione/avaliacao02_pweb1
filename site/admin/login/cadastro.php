<?php
include 'headerLogin.php';

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = '';

if(!empty($_GET['id'])) {  //vai procurar pelo id
    $data = $db->find($_GET['id']);
} 

if (!empty($_POST)) {

    $data = (object) $_POST; 
    try {
        if (empty($_POST['nome'])) {
            $errors[] = "<li>O nome é obrigatório</li>";
        }
        if (empty($_POST['email'])) {
            $errors[] = "<li>O email é obrigatório</li>";
        }
        if (empty($_POST['login'])) {
            $errors[] = "<li>O login é obrigatório</li>";
        }

        //Campos de verificação da senha
        if(strlen($_POST['senha']) < 6) {
            $errors[] = "<li>A senha deve conter no mínimo 6 caracteres</li>";
            }
        if (empty($_POST['senha'])) {
            $errors[] = "<li>A senha é obrigatória</li>";
        }

        if (empty($errors)) {
            if(empty($_POST['id'])) {
                //o código está enviando um id vazio para o banco, se não existir um id, ele deve ser retirado, para que então seja possível ao banco inserir automaticamente
                unset($_POST['id']);
                $usuario = $db->findBy('login', $_POST['login']); 
                if($usuario){
                    $errors[] = "<li>O login já existe. Por favor, escolha outro.</li>";
                }
                $dado = [
                    'nome' => $_POST['nome'],
                    'telefone' => $_POST['telefone'] ? $_POST['telefone'] : "", // ?-> se for vdd. : -> se for falso.
                    'email' => $_POST['email'],
                    'login' => $_POST['login'],
                    'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT), //PASSWORD_DEFAULT é os pontinhos
                    'tipo' => $_POST['tipo']
                ];

                $db->store($dado); //salva no banco
                $success = "Registro Salvo com sucesso!";
                $db->redirect('./login.php');
            }
            else {
                $dado = [
                    'id'       => $_POST['id'],
                    'nome'     => $_POST['nome'],
                    'telefone' => $_POST['telefone'] ? $_POST['telefone'] : "", 
                    'email'    => $_POST['email'],
                    'login'    => $_POST['login'],
                    'tipo'     => $_POST['tipo']
                ];
                if (!empty($_POST['senha'])) {
                    $dado['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                }
                
                $db->update($dado); 
                $success = "Registro Atualizado com sucesso!";
                $db->redirect('/avaliacao02_pweb1/site/admin/usuario/contaUsuario.php');
            }

        }
    } catch (PDOException $e) { //se o erro for no banco
        $actionError = $e->getMessage(); 
    } catch (Exception $e) { //se o erro for no PHP
        $actionError = $e->getMessage();
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <?php $db->actionMessage($success, $actionError); ?>
            <?php $db->showValidationError($errors); ?>

            <div class="card shadow border-0 rounded-4 overflow-hidden bg-white">
                
                <div class="d-flex align-items-center justify-content-center px-4" style="height: 90px; background: #4c32a8">
                    <h4 class="fw-bold text-white m-0">
                        Criar Conta - Bibi TV
                    </h4>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label small fw-semibold text-muted">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-id-card-clip-alt text-muted"></i></span>
                                    <input type="text" name="nome" id="nome" class="form-control border-2 border-start-0 text-secondary" placeholder="Ex: João Silva" value="<?php echo $db->getFormValue($data, 'nome'); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="telefone" class="form-label small fw-semibold text-muted">Telefone / Celular</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-phone-call text-muted"></i></span>
                                    <input type="text" name="telefone" id="telefone" class="form-control border-2 border-start-0 text-secondary" placeholder="(00) 00000-0000" value="<?php echo $db->getFormValue($data, 'telefone'); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold text-muted">Endereço de E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-2 border-start-0 text-secondary" placeholder="exemplo@email.com" value="<?php echo $db->getFormValue($data, 'email'); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="login" class="form-label small fw-semibold text-muted">Nome de Usuário (Login)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-user text-muted"></i></span>
                                    <input type="text" name="login" id="login" class="form-control border-2 border-start-0 text-secondary" placeholder="Login" value="<?php echo $db->getFormValue($data, 'login'); ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="senha" class="form-label small fw-semibold text-muted">Senha de Acesso</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0"><i class="fi fi-rr-key text-muted"></i></span>
                                    <input type="password" name="senha" id="senha" class="form-control border-2 border-start-0 text-secondary" placeholder="Mínimo de 6 caracteres">
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="tipo" value="1"> 

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="./login.php" class="text-decoration-none text-muted fw-semibold">Já possui uma conta? Entre aqui
                            </a>
                            <button type="submit" class="btn fw-bold text-dark border-0 px-4 py-2 rounded-3" 
                                    style="background-color: #fbd28c;">Salvar Cadastro
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div><div>
<?php
include '../../footer.php';
?>