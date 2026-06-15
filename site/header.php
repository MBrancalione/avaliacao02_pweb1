<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/site/admin/db.class.php';
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibi TV - Painel Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <link rel="stylesheet" href="./categoria/css/styles.css">

  </head>

    <body>
        <header class="custom-header mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3">
                       <a href="/site/admin/indexAdmin.php" class="text-decoration-none d-flex align-items-baseline gap-2">
                            <h4>Bibi TV</h4>
                            <small class="fw-semibold" style="font-size: 0.85rem; color: #fbd28c;">- Painel ADMIN</small>
                        </a>
                    </div>
                    <div class="col-md-9">
                        <nav class="nav justify-content-end align-items-center gap-2">
                            
                            <a class="nav-link nav-link-custom d-inline-flex align-items-center gap-2" href="/site/admin/usuario/indexUsuario.php">Home</a>
                            <a class="nav-link nav-link-custom" href="/site/admin/pages/listCatalogo.php">Catálogo</a>
                            <a class="nav-link nav-link-custom" href="/site/admin/pages/listPlano.php">Planos</a>
                            <a class="nav-link nav-link-custom" href="/site/admin/usuario/listUsuario.php">Usuáriosㅤㅤ</a>
                            <a class="btn btn-sm btn-header-logout px-3" href="/site/admin/login/logout.php">Sair</a>
                        </nav>
                    </div>
                </div>
            </div>
        </header>