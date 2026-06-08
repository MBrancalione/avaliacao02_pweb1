<?php
include 'C:\Users\rynbo\OneDrive\Documentos\GitHub\avaliacao02_pweb1\site\header.php'; //inclui desta forma, pois ele dava erro da forma relativa. Mantive assim por enquanto
include_once "..\db.class.php";

$db = new db('usuario');
$success = '';
$actionError = '';
$errors = [];
$data = '';


if(!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {

    $data = (object) $_POST; //converte o array associativo do post para um objeto para facilitar o acesso aos campos
    try {

        if (empty($_POST['nome'])) {
            $errors[] = "<li>O nome é obrigatório</li>";
        }

        if (empty($_POST['telefone'])) {
            $errors[] = "<li>O telefone é obrigatório</li>";
        }

        if (empty($_POST['senha'])) {
                    $errors[] = "<li>O senha é obrigatório</li>";
                }

        /////////////////////////////////////////////

        //Aqui estou tentando fazer com que ele verifique no banco se o email já existe com outra conta
        
        if(!empty($_POST['email']) && empty($_POST['id'])) {

        $email_escolhido = trim($_POST['email']);

        //usa o metodo findby do db.class.php para comparar dados
        $email_existe = $db->findBy('email', $email_escolhido);
        
        //var_dump($email_existe); se o valor desse var_dump for algo diferente de nada/vazio, ele entra no IF, pois ele encontrou um email igual dentro dos registros do banco
        if ($email_existe > 0){
            $errors[] =  "O email " . ($email_escolhido) . " já está em uso. Por favor, escolha outro.";
        }
        }
    
        ////////////////////////////////////////////////////////
        

        if (empty($errors)) {
            if(empty($_POST['id'])) {
                //o código está enviando um id vazio para o banco, se não existir um id, ele deve ser retirado, para que então seja possível ao banco inserir automaticamente
                unset($_POST['id']);

                $db->store($_POST);
                $success = "Registro Salvo com sucesso!";
            } else {
                $db->update($_POST, $_POST['id']);
                $success = "Registro atualizado com sucesso!";
            }
            $success = "Registro Salvo com sucesso!";

            redirect('UserList.php');
        }
    } catch (PDOException $e) {
        $actionError = $e->getMessage();
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}


?>

<div class="row">
    <!-- <?php actionMessage($success, $actionError) ?> COMENTARIO AQUI-->
    <?php showValidationError($errors) ?>

    <form action="./usuarioForm.php" method="post">
        <h3>Formulário Usuário</h3>

        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 

        <div class="col-6">
            <label for="nome">Nome</label>
            <input type="text" name="nome" class="form-control" value="<?php echo getFormValue($data, 'nome'); ?>">
        </div>
        <div class="col-6">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo getFormValue($data, 'email'); ?>">
        </div>
        <div class="col-6">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" class="form-control" value="<?php echo getFormValue($data, 'telefone'); ?>">
        </div>
        <div class="col-6">
            <label for="telefone">Senha</label>
            <input type="text" name="senha" class="form-control" value="<?php echo getFormValue($data, 'senha'); ?>">
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="usuarioList.php" class="btn btn-primary"> Voltar</a>
        </div>
</div>


    </form>

</div>

<?php
include 'C:\Users\rynbo\OneDrive\Documentos\GitHub\avaliacao02_pweb1\site\footer.php';
?>