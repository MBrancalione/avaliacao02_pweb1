<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibi TV</title>
  </head>


  <?php
    // Função para redirecionar para outra página após um tempo determinado
    function redirect($page, $time = 500){
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

    // Função para exibir erros de validação dos campos
    function showValidationError($errors = [])
    {
        if (!empty($errors)) {
            echo "<div class='alert alert-danger' role='alert'><ul>";
            echo "<strong>Erros nos campos:</strong>";
            foreach ($errors as $error) {
                echo $error;
            }
            echo "</ul></div>";
        }
    }   

    // Função para obter o valor de um campo de formulário, usada no login
    function getFormValue($data, $field='')
    {
        return isset($data->$field) ? $data->$field : '';
    }
?>
  <body>
    <div class="container">
        <div class="row">
            <h4>OIOIOI isso é um teste para ver se o header está aparecendo :p </h4>

  