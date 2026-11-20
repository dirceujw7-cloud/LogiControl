<?php
require_once __DIR__.'/../config/conexao.php';require_once __DIR__.'/../config/funcoes.php';
$tituloPagina='Fretes';
$sql="SELECT f.*, o.identificacao AS origem, d.identificacao AS destino, t.nome AS transportador FROM fretes f JOIN enderecos o ON o.id=f.origem_id JOIN enderecos d ON d.id=f.destino_id JOIN transportadores t ON t.id=f.transportador_id ORDER BY f.data_frete DESC, f.id DESC";
$dados=$pdo->query($sql)->fetchAll();require __DIR__.'/../includes/header.php';?>
<div class="d-flex justify-content-between mb-3"><h1 class="page-title">Fretes</h1><a class="btn btn-success" href="cadastrar.php">+ Gerar frete</a></div>
<div class="card p-3 table-responsive"><table class="table align-middle"><thead><tr><th>Nº</th><th>Data</th><th>Origem</th><th>Destino</th><th>Transportador</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($dados as $f):?><tr><td>#<?=$f['id']?></td><td><?=date('d/m/Y',strtotime($f['data_frete']))?></td><td><?=h($f['origem'])?></td><td><?=h($f['destino'])?></td><td><?=h($f['transportador'])?></td><td><?=h($f['status'])?></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="visualizar.php?id=<?=$f['id']?>">Detalhes</a> <a class="btn btn-sm btn-outline-danger" href="excluir.php?id=<?=$f['id']?>" onclick="return confirm('Excluir este frete?')">Excluir</a></td></tr><?php endforeach;?>
<?php if(!$dados):?><tr><td colspan="7" class="text-center text-secondary">Nenhum frete cadastrado.</td></tr><?php endif;?></tbody></table></div><?php require __DIR__.'/../includes/footer.php';?>
