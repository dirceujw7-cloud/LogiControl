<?php
require_once __DIR__.'/../config/conexao.php';require_once __DIR__.'/../config/funcoes.php';
$tituloPagina='Transportadores';$dados=$pdo->query('SELECT * FROM transportadores ORDER BY nome')->fetchAll();require __DIR__.'/../includes/header.php';?>
<div class="d-flex justify-content-between mb-3"><h1 class="page-title">Transportadores</h1><a class="btn btn-success" href="cadastrar.php">+ Novo transportador</a></div>
<?php if(isset($_GET['ok'])):?><div class="alert alert-success">Operação realizada com sucesso.</div><?php endif;?>
<div class="card p-3 table-responsive"><table class="table align-middle"><thead><tr><th>Nome</th><th>Documento</th><th>Veículo</th><th>Placa</th><th>Status</th><th>Ações</th></tr></thead><tbody>
<?php foreach($dados as $t):?><tr><td><?=h($t['nome'])?></td><td><?=h($t['documento'])?></td><td><?=h($t['veiculo'])?></td><td><?=h($t['placa'])?></td><td><?=h(ucfirst($t['status']))?></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?=$t['id']?>">Editar</a> <a class="btn btn-sm btn-outline-danger" href="excluir.php?id=<?=$t['id']?>" onclick="return confirm('Excluir este transportador?')">Excluir</a></td></tr><?php endforeach;?>
<?php if(!$dados):?><tr><td colspan="6" class="text-center text-secondary">Nenhum transportador cadastrado.</td></tr><?php endif;?></tbody></table></div><?php require __DIR__.'/../includes/footer.php';?>
