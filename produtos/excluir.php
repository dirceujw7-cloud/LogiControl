<?php
require_once __DIR__.'/../config/conexao.php'; require_once __DIR__.'/../config/funcoes.php';
$id=(int)($_GET['id']??0);
try { $st=$pdo->prepare('DELETE FROM produtos WHERE id=?'); $st->execute([$id]); } catch(PDOException $e) {}
redirecionar('listar.php?ok=1');
