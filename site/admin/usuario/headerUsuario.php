<?php
include_once "../db.class.php";
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibi TV</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../categoria/css/styles.css">

  </head>

  <body>
    <header class="custom-header mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="./indexUsuario.php" class="text-decoration-none">
                        <h4>Bibi TV</h4>
                    </a>
                </div>
            <div class="col-md-9">
                <nav class="nav justify-content-end align-items-center gap-2">
                    <a class="nav-link nav-link-custom d-inline-flex align-items-center gap-2" href="/avaliacao02_pweb1/site/admin/usuario/catalogoUsuario.php">
                        <i class="fi fi-rr-search" style="font-size: 1.1rem; line-height: 1;"></i> Pesquisa
                    </a>
                    <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/usuario/avaliaList.php">Avaliações</a>
                    <a class="nav-link nav-link-custom" href="/avaliacao02_pweb1/site/admin/usuario/contaUsuario.php">Contaㅤㅤ</a>
                    <a class="btn btn-sm btn-header-logout px-3" href="/avaliacao02_pweb1/site/admin/login/logout.php">Sair</a>
                </nav>
            </div>
            </div>
        </div>
    </header>