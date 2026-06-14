<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibi TV</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./admin/categoria/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </head>

  <?php
    function redirect($page, $time = 500){
        echo "<script>setTimeout(()=>window.location.href='$page', '$time')</script>";
    }

    function actionMessage($success, $error){
        if(!empty($success)){
            echo "<div class='alert alert-success' role='alert'>$success</div>";
        }
        if(!empty($error)){
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
    }

    function showValidationError($errors = [])
    {
        if (!empty($errors)) {
            echo "<div class='alert alert-danger' role='alert'><ul>";
            echo "<strong>Erros nos campos:</strong>";
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>"; 
            }
            echo "</ul></div>";
        }
    }   

    /*função para preencher os campos do formulário com os dados do banco, caso seja uma edição, ou deixar vazio caso seja um cadastro */
    function getFormValue($data, $field='')
    {
        return isset($data->$field) ? $data->$field : '';
    }
  ?>
  
  <body>
    <header class="custom-header" style="background-color: var(--lilas);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="./index.html"><img class="logo" src="./img/logos/logobranca.png" alt="logo"></a>
                </div>
                <div class="col-md-9">
                    <nav class="nav justify-content-end align-items-center gap-2">
                        <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/indexAdmin.php">Home</a>
                        <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/pages/listCatalogo.php">Catalogo</a>
                        <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/pages/listPlano.php">Planos</a>
                        <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/usuario/listUsuario.php">Usuários</a>
                        <a class="btn btn-sm btn-header-logout px-3" href="/avaliacao02_pweb1/site/admin/login/logout.php">Sair</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">