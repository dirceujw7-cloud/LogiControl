<?php
require_once __DIR__.'/../config/conexao.php'; require_once __DIR__.'/../config/funcoes.php';
$tituloPagina='Produtos'; $dados=$pdo->query('SELECT * FROM produtos ORDER BY nome')->fetchAll();
require __DIR__.'/../includes/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="page-title">Produtos</h1><a class="btn btn-success" href="cadastrar.php">+ Novo produto</a></div>
<?php if(isset($_GET['ok'])): ?><div class="alert alert-success">Operação realizada com sucesso.</div><?php endif; ?>
<div class="card p-3"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Código</th><th>Nome</th><th>Peso (kg)</th><th>Valor (R$)</th><th>Estoque</th><th>Ações</th></tr></thead><tbody>
<?php foreach($dados as $p): ?><tr><td><?=h($p['codigo'])?></td><td><?=h($p['nome'])?></td><td><?=h($p['peso'])?></td><td><?=number_format((float)$p['valor'],2,',','.')?></td><td><?=h($p['quantidade'])?></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?=$p['id']?>">Editar</a> <a class="btn btn-sm btn-outline-danger" href="excluir.php?id=<?=$p['id']?>" onclick="return confirm('Excluir este produto?')">Excluir</a></td></tr><?php endforeach; ?>
<?php if(!$dados): ?><tr><td colspan="6" class="text-center text-secondary">Nenhum produto cadastrado.</td></tr><?php endif; ?>
</tbody></table></div></div><?php require __DIR__.'/../includes/footer.php'; ?>
