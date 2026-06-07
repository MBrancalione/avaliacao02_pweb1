<?php
include '../../header.php';
include_once "../db.class.php";

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = '';

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
                $_SESSION['user_id'] = $usuario->id; //armazena o ID do usuário na sessão para manter o estado de login
                $_SESSION['user_login'] = $usuario->login; 
                $_SESSION['user_nome'] = $usuario->nome;
                $_SESSION['user_tipo'] = $usuario->tipo;
                $success = "Login bem-sucedido! Redirecionando para o painel...";
                redirect('../index.php', 1000);
            }
        }
    } catch (PDOException $e){
        $actionError = $e->getMessage();
    } catch (PDOException $e){
    $actionError = $e->getMessage();
    }
}
?>

<div>
    <?php actionMessage($success, $actionError) ?>
    <?php showValidationError($errors) ?>

    <form action="./login.php" method="POST"> <!--mudar para redirecionar par a página principal-->
        <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" name="login" value="<?php echo getFormValue($data, 'login'); ?>">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" name="senha" value="<?php echo getFormValue($data, 'senha'); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>