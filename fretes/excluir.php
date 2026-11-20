<?php
require_once __DIR__.'/../config/conexao.php';require_once __DIR__.'/../config/funcoes.php';
$id=(int)($_GET['id']??0);$st=$pdo->prepare('DELETE FROM fretes WHERE id=?');$st->execute([$id]);redirecionar('listar.php');
