<?php
require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/config/funcoes.php';
$tituloPagina = 'Painel inicial';
$totalProdutos = (int)$pdo->query('SELECT COUNT(*) FROM produtos')->fetchColumn();
$totalEnderecos = (int)$pdo->query('SELECT COUNT(*) FROM enderecos')->fetchColumn();
$totalTransportadores = (int)$pdo->query('SELECT COUNT(*) FROM transportadores')->fetchColumn();
$totalFretes = (int)$pdo->query('SELECT COUNT(*) FROM fretes')->fetchColumn();
$emAndamento = (int)$pdo->query("SELECT COUNT(*) FROM fretes WHERE status IN ('Pendente','Em transporte')")->fetchColumn();
require __DIR__ . '/includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
 <div><h1 class="page-title mb-1">Painel de controle</h1><p class="text-secondary mb-0">Visão geral da operação logística.</p></div>
 <a class="btn btn-success mt-2" href="fretes/cadastrar.php">+ Gerar novo frete</a>
</div>
<div class="row g-3">
 <?php foreach ([['Produtos',$totalProdutos,'bi-box'],['Endereços',$totalEnderecos,'bi-geo'],['Transportadores',$totalTransportadores,'bi-truck'],['Fretes cadastrados',$totalFretes,'bi-receipt'],['Fretes em andamento',$emAndamento,'bi-clock']] as $item): ?>
 <div class="col-12 col-sm-6 col-lg-4"><div class="card p-4 h-100"><div class="text-secondary"><?= h($item[0]) ?></div><div class="stat-number"><?= $item[1] ?></div></div></div>
 <?php endforeach; ?>
</div>
<div class="card p-4 mt-4"><h5>Comece por aqui</h5><p class="text-secondary mb-3">Cadastre os produtos, endereços e transportadores antes de gerar seu primeiro frete.</p>
<div class="d-flex flex-wrap gap-2"><a class="btn btn-outline-primary" href="produtos/listar.php">Cadastrar produtos</a><a class="btn btn-outline-primary" href="enderecos/listar.php">Cadastrar endereços</a><a class="btn btn-outline-primary" href="transportadores/listar.php">Cadastrar transportadores</a></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
