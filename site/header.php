<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibi TV</title>
  </head>


  <?php
    // Função para redirecionar para outra página após um tempo determinado
    function redirect($page, $time = 1500){
        echo "<script>setTimeout(()=>window.location.href='$page', '$time')</script>";
    }
    // Função para exibir mensagens de sucesso ou erro
    function actionMessage($success, $error){
        if(!empty($success)){
            echo "<div class='alert alert-success' role='alert'>$success</div>";
        }
        if(!empty($error)){
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
    }
  ?>
  <body>
    <div class="container">
        <div class="row">
<!--fechamento das tags vão para a página destinada ao footer - faz sentido? não-->

  