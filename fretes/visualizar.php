<?php
require_once __DIR__.'/../config/conexao.php';require_once __DIR__.'/../config/funcoes.php';
$id=(int)($_GET['id']??0);
$st=$pdo->prepare("SELECT f.*,o.identificacao AS origem,o.cep AS cep_origem,o.rua AS rua_origem,o.numero AS numero_origem,o.cidade AS cidade_origem,o.estado AS uf_origem,d.identificacao AS destino,d.cep AS cep_destino,d.rua AS rua_destino,d.numero AS numero_destino,d.cidade AS cidade_destino,d.estado AS uf_destino,t.nome AS transportador,t.documento,t.veiculo,t.placa FROM fretes f JOIN enderecos o ON o.id=f.origem_id JOIN enderecos d ON d.id=f.destino_id JOIN transportadores t ON t.id=f.transportador_id WHERE f.id=?");
$st->execute([$id]);$f=$st->fetch();if(!$f)redirecionar('listar.php');
$st=$pdo->prepare('SELECT p.codigo,p.nome,fp.quantidade FROM frete_produtos fp JOIN produtos p ON p.id=fp.produto_id WHERE fp.frete_id=?');$st->execute([$id]);$itens=$st->fetchAll();
$tituloPagina='Detalhes do frete';require __DIR__.'/../includes/header.php';?>
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="page-title">Frete #<?=$f['id']?></h1><a class="btn btn-outline-secondary" href="listar.php">Voltar</a></div>
<div class="card p-4 mb-3"><div class="row g-3"><div class="col-md-4"><strong>Data:</strong> <?=date('d/m/Y',strtotime($f['data_frete']))?></div><div class="col-md-4"><strong>Status:</strong> <?=h($f['status'])?></div><div class="col-md-4"><strong>Transportador:</strong> <?=h($f['transportador'])?></div>
<div class="col-md-6"><h5 class="mt-2">Origem</h5><?=h($f['origem'])?><br><?=h($f['rua_origem'])?>, <?=h($f['numero_origem'])?><br><?=h($f['cidade_origem'])?>/<?=h($f['uf_origem'])?> - CEP <?=h($f['cep_origem'])?></div>
<div class="col-md-6"><h5 class="mt-2">Destino</h5><?=h($f['destino'])?><br><?=h($f['rua_destino'])?>, <?=h($f['numero_destino'])?><br><?=h($f['cidade_destino'])?>/<?=h($f['uf_destino'])?> - CEP <?=h($f['cep_destino'])?></div>
<div class="col-12"><strong>Veículo:</strong> <?=h($f['veiculo'])?> | <strong>Placa:</strong> <?=h($f['placa'])?></div>
</div></div>
<div class="card p-4"><h5>Produtos deste frete</h5><div class="table-responsive"><table class="table"><thead><tr><th>Código</th><th>Produto</th><th>Quantidade</th></tr></thead><tbody><?php foreach($itens as $i):?><tr><td><?=h($i['codigo'])?></td><td><?=h($i['nome'])?></td><td><?=h($i['quantidade'])?></td></tr><?php endforeach;?></tbody></table></div><?php if($f['observacoes']):?><strong>Observações:</strong><p><?=nl2br(h($f['observacoes']))?></p><?php endif;?></div>
<?php require __DIR__.'/../includes/footer.php';?>
