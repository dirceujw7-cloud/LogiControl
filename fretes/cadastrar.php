<?php
require_once __DIR__.'/../config/conexao.php';require_once __DIR__.'/../config/funcoes.php';
$tituloPagina='Gerar frete';$erro='';
$enderecos=$pdo->query('SELECT * FROM enderecos ORDER BY identificacao')->fetchAll();
$transportadores=$pdo->query("SELECT * FROM transportadores WHERE status='ativo' ORDER BY nome")->fetchAll();
$produtos=$pdo->query('SELECT * FROM produtos ORDER BY nome')->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $data=valorPost('data_frete');$origem=(int)($_POST['origem_id']??0);$destino=(int)($_POST['destino_id']??0);$transportador=(int)($_POST['transportador_id']??0);$status=valorPost('status','Pendente');$obs=valorPost('observacoes');
 $ids=$_POST['produto_id']??[];$qtds=$_POST['quantidade']??[];
 $itens=[];foreach($ids as $i=>$pid){$pid=(int)$pid;$q=(int)($qtds[$i]??0);if($pid>0&&$q>0)$itens[]=['id'=>$pid,'qtd'=>$q];}
 if(!$data||!$origem||!$destino||!$transportador||!count($itens))$erro='Preencha os dados do frete e adicione pelo menos um produto com quantidade.';
 elseif($origem===$destino)$erro='A origem e o destino precisam ser diferentes.';
 else{
  try{$pdo->beginTransaction();
   $st=$pdo->prepare('INSERT INTO fretes(data_frete,origem_id,destino_id,transportador_id,status,observacoes) VALUES(?,?,?,?,?,?)');$st->execute([$data,$origem,$destino,$transportador,$status,$obs]);$freteId=(int)$pdo->lastInsertId();
   $st=$pdo->prepare('INSERT INTO frete_produtos(frete_id,produto_id,quantidade) VALUES(?,?,?)');
   foreach($itens as $item)$st->execute([$freteId,$item['id'],$item['qtd']]);
   $pdo->commit();redirecionar('visualizar.php?id='.$freteId);
  }catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();$erro='Não foi possível gerar o frete. Confira os dados e tente novamente.';}
 }
}
require __DIR__.'/../includes/header.php';?>
<h1 class="page-title mb-3">Gerar novo frete</h1>
<?php if($erro):?><div class="alert alert-danger"><?=h($erro)?></div><?php endif;?>
<?php if(!$enderecos||!$transportadores||!$produtos):?><div class="alert alert-warning">Antes de gerar um frete, cadastre pelo menos um endereço, um transportador ativo e um produto.</div><?php endif;?>
<form method="post" class="card p-4">
<div class="row g-3">
<div class="col-md-4"><label class="form-label required">Data do frete</label><input class="form-control" type="date" name="data_frete" required value="<?=h($_POST['data_frete']??date('Y-m-d'))?>"></div>
<div class="col-md-4"><label class="form-label required">Origem</label><select class="form-select" name="origem_id" required><option value="">Selecione</option><?php foreach($enderecos as $e):?><option value="<?=$e['id']?>" <?=($_POST['origem_id']??'')==$e['id']?'selected':''?>><?=h($e['identificacao'])?></option><?php endforeach;?></select></div>
<div class="col-md-4"><label class="form-label required">Destino</label><select class="form-select" name="destino_id" required><option value="">Selecione</option><?php foreach($enderecos as $e):?><option value="<?=$e['id']?>" <?=($_POST['destino_id']??'')==$e['id']?'selected':''?>><?=h($e['identificacao'])?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label class="form-label required">Transportador</label><select class="form-select" name="transportador_id" required><option value="">Selecione</option><?php foreach($transportadores as $t):?><option value="<?=$t['id']?>" <?=($_POST['transportador_id']??'')==$t['id']?'selected':''?>><?=h($t['nome'])?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status"><option>Pendente</option><option>Em transporte</option><option>Concluído</option><option>Cancelado</option></select></div>
<div class="col-12"><hr><div class="d-flex justify-content-between align-items-center"><h5>Produtos transportados</h5><button type="button" class="btn btn-sm btn-outline-success" id="adicionar-produto">+ Adicionar produto</button></div>
<div id="lista-produtos"><div class="row g-2 align-items-end produto-linha mb-2"><div class="col-md-8"><label class="form-label">Produto</label><select class="form-select" name="produto_id[]" required><option value="">Selecione</option><?php foreach($produtos as $p):?><option value="<?=$p['id']?>"><?=h($p['codigo'].' - '.$p['nome'])?></option><?php endforeach;?></select></div><div class="col-md-3"><label class="form-label">Quantidade</label><input class="form-control" type="number" name="quantidade[]" min="1" value="1" required></div><div class="col-md-1"><button type="button" class="btn btn-outline-danger remover-produto" title="Remover">×</button></div></div></div>
</div>
<div class="col-12"><label class="form-label">Observações</label><textarea class="form-control" name="observacoes" rows="3"><?=h($_POST['observacoes']??'')?></textarea></div>
</div><div class="mt-4"><button class="btn btn-primary" <?=(!$enderecos||!$transportadores||!$produtos)?'disabled':''?>>Salvar frete</button> <a class="btn btn-light" href="listar.php">Cancelar</a></div>
</form><?php require __DIR__.'/../includes/footer.php';?>
