<?php
require_once __DIR__.'/../config/conexao.php'; require_once __DIR__.'/../config/funcoes.php';
$tituloPagina='Endereços'; $dados=$pdo->query('SELECT * FROM enderecos ORDER BY identificacao')->fetchAll(); require __DIR__.'/../includes/header.php'; ?>
<div class="d-flex justify-content-between mb-3"><h1 class="page-title">Endereços</h1><a class="btn btn-success" href="cadastrar.php">+ Novo endereço</a></div>
<?php if(isset($_GET['ok'])):?><div class="alert alert-success">Operação realizada com sucesso.</div><?php endif;?>
<div class="card p-3 table-responsive"><table class="table align-middle"><thead><tr><th>Identificação</th><th>Tipo</th><th>Endereço</th><th>Cidade/UF</th><th>Ações</th></tr></thead><tbody>
<?php foreach($dados as $e):?><tr><td><?=h($e['identificacao'])?></td><td><?=h(ucfirst($e['tipo']))?></td><td><?=h($e['rua'])?>, <?=h($e['numero'])?> - <?=h($e['bairro'])?></td><td><?=h($e['cidade'])?>/<?=h($e['estado'])?></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?=$e['id']?>">Editar</a> <a class="btn btn-sm btn-outline-danger" href="excluir.php?id=<?=$e['id']?>" onclick="return confirm('Excluir este endereço?')">Excluir</a></td></tr><?php endforeach;?>
<?php if(!$dados):?><tr><td colspan="5" class="text-center text-secondary">Nenhum endereço cadastrado.</td></tr><?php endif;?></tbody></table></div>
<?php require __DIR__.'/../includes/footer.php';?>
