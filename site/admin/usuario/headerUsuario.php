<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibi TV</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
      .custom-header {
        background-color: #e5dbff;
        color: #4c32a8;
        padding: 15px 0;
        margin-bottom: 30px;
        border-bottom: 2px solid #fff; 
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); 
      }
      .custom-header h4 {
        margin: 0;
        font-weight: 700;
      }
      .nav-link-custom {
        color: #4c32a8 !important;
        font-weight: 500;
        transition: opacity 0.2s;
      }
      .nav-link-custom:hover {
        opacity: 0.8;
      }
      .btn-header-logout {
        background-color: #4c32a8;
        color: #fff !important;
      }
    </style>
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

    function getFormValue($data, $field='')
    {
        return isset($data->$field) ? $data->$field : '';
    }
  ?>
  
  <body>
    <header class="custom-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="../../index.php" class="text-decoration-none">
                        <h4>Bibi TV</h4>
                    </a>
                </div>
                <div class="col-md-9">
                    <nav class="nav justify-content-end align-items-center gap-2">
                        <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/usuario/indexUsuario.php">Home</a>
                        <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/usuario/avaliaList.php">Avaliações</a>
                        <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/usuario/contaUsuario.php">Conta</a>
                        <a class="btn btn-sm btn-header-logout px-3" href="/avaliacao02_pweb1/site/admin/login/logout.php">Sair</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">