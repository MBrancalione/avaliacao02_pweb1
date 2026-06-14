<?php
include '../../header.php';
include_once "../db.class.php";

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = '';

if(!empty($_GET['id'])) {  
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
        if (empty($_POST['senha'])) {
            $errors[] = "<li>A senha é obrigatória</li>";
            if(strlen($_POST['senha']) < 6) {
                $errors[] = "<li>A senha deve conter no mínimo 6 caracteres</li>";
            }
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
                    'telefone' => $_POST['telefone'] ? $_POST['telefone'] : "",
                    'email' => $_POST['email'],
                    'login' => $_POST['login'],
                    'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
                    'tipo' => $_POST['tipo']
                ];

                $db->store($dado);
                $success = "Registro Salvo com sucesso!";
                redirect('./login.php');
            }
            else {
                // Atualização
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
                redirect('/avaliacao02_pweb1/site/admin/usuario/contaUsuario.php');
            }

        }
    } catch (PDOException $e) {
        $actionError = $e->getMessage();
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}
?>

<div class="row">
    <?php actionMessage($success, $actionError) ?>
    <?php showValidationError($errors) ?>

    <form action="" method="post">
        <h3>Registar Usuário</h3>
        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 
        <div class="col-6">
            <label for="nome">Nome</label>
            <input type="text" name="nome" class="form-control" value="<?php echo getFormValue($data, 'nome'); ?>">
        </div>
        <div class="col-6">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" class="form-control" value="<?php echo getFormValue($data, 'telefone'); ?>">
        </div>
        <div class="col-6">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo getFormValue($data, 'email'); ?>">
        </div>
        <div class="col-6">
            <label for="login">Login</label>
            <input type="text" name="login" class="form-control" value="<?php echo getFormValue($data, 'login'); ?>">
        </div>
        <div class="col-6">
            <label for="senha">Senha</label>
            <input type="password" name="senha" class="form-control" value="<?php echo getFormValue($data, 'senha'); ?>">
        </div>
        <input type="hidden" name="tipo" value="1"> <!--cadastra como usuário automaticamente -->
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>

<?php
include '../../footer.php';
?>