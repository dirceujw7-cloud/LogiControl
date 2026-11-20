<?php
$tituloPagina = $tituloPagina ?? 'LogiControl';
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($tituloPagina) ?> | LogiControl</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/LogiControl/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark topbar">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/LogiControl/index.php">📦 LogiControl</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/LogiControl/index.php">Início</a></li>
        <li class="nav-item"><a class="nav-link" href="/LogiControl/produtos/listar.php">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" href="/LogiControl/enderecos/listar.php">Endereços</a></li>
        <li class="nav-item"><a class="nav-link" href="/LogiControl/transportadores/listar.php">Transportadores</a></li>
        <li class="nav-item"><a class="nav-link" href="/LogiControl/fretes/listar.php">Fretes</a></li>
        <li class="nav-item"><a class="nav-link" href="/LogiControl/relatorios/fretes.php">Relatórios</a></li>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">
