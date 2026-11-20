<?php
require_once __DIR__.'/../config/conexao.php';require_once __DIR__.'/../config/funcoes.php';
$tituloPagina='Relatório de fretes';$inicio=$_GET['inicio']??date('Y-m-01');$fim=$_GET['fim']??date('Y-m-d');
if(isset($_GET['baixar'])){
 $st=$pdo->prepare("SELECT f.id,f.data_frete,f.status,o.identificacao AS origem,d.identificacao AS destino,t.nome AS transportador,GROUP_CONCAT(CONCAT(p.nome,' (',fp.quantidade,')') SEPARATOR '; ') AS produtos FROM fretes f JOIN enderecos o ON o.id=f.origem_id JOIN enderecos d ON d.id=f.destino_id JOIN transportadores t ON t.id=f.transportador_id LEFT JOIN frete_produtos fp ON fp.frete_id=f.id LEFT JOIN produtos p ON p.id=fp.produto_id WHERE f.data_frete BETWEEN ? AND ? GROUP BY f.id ORDER BY f.data_frete");
 $st->execute([$inicio,$fim]);$linhas=$st->fetchAll();
 header('Content-Type: text/csv; charset=utf-8');header('Content-Disposition: attachment; filename=relatorio_fretes.csv');
 $saida=fopen('php://output','w');fwrite($saida,"\xEF\xBB\xBF");fputcsv($saida,['Número','Data','Origem','Destino','Transportador','Status','Produtos'],';');
 foreach($linhas as $l)fputcsv($saida,[$l['id'],$l['data_frete'],$l['origem'],$l['destino'],$l['transportador'],$l['status'],$l['produtos']],';');
 fclose($saida);exit;
}
$st=$pdo->prepare("SELECT f.id,f.data_frete,f.status,o.identificacao AS origem,d.identificacao AS destino,t.nome AS transportador FROM fretes f JOIN enderecos o ON o.id=f.origem_id JOIN enderecos d ON d.id=f.destino_id JOIN transportadores t ON t.id=f.transportador_id WHERE f.data_frete BETWEEN ? AND ? ORDER BY f.data_frete DESC");$st->execute([$inicio,$fim]);$dados=$st->fetchAll();
require __DIR__.'/../includes/header.php';?>
<h1 class="page-title mb-3">Relatório de fretes</h1>
<form class="card p-3 mb-3"><div class="row g-3 align-items-end"><div class="col-md-4"><label class="form-label">Data inicial</label><input class="form-control" type="date" name="inicio" value="<?=h($inicio)?>"></div><div class="col-md-4"><label class="form-label">Data final</label><input class="form-control" type="date" name="fim" value="<?=h($fim)?>"></div><div class="col-md-2"><button class="btn btn-primary w-100">Filtrar</button></div><div class="col-md-2"><button class="btn btn-success w-100" name="baixar" value="1">Baixar CSV</button></div></div></form>
<div class="card p-3"><p class="text-secondary">Foram encontrados <strong><?=count($dados)?></strong> frete(s) no período.</p><div class="table-responsive"><table class="table"><thead><tr><th>Nº</th><th>Data</th><th>Origem</th><th>Destino</th><th>Transportador</th><th>Status</th></tr></thead><tbody><?php foreach($dados as $f):?><tr><td>#<?=$f['id']?></td><td><?=date('d/m/Y',strtotime($f['data_frete']))?></td><td><?=h($f['origem'])?></td><td><?=h($f['destino'])?></td><td><?=h($f['transportador'])?></td><td><?=h($f['status'])?></td></tr><?php endforeach;?><?php if(!$dados):?><tr><td colspan="6" class="text-center text-secondary">Nenhum frete encontrado neste período.</td></tr><?php endif;?></tbody></table></div></div>
<?php require __DIR__.'/../includes/footer.php';?>
