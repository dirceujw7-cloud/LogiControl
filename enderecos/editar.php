<?php
require_once __DIR__.'/../config/conexao.php'; require_once __DIR__.'/../config/funcoes.php';
$id=(int)($_GET['id']??0); $edicao=$id>0; $erro='';
$e=['identificacao'=>'','tipo'=>'ambos','cep'=>'','rua'=>'','numero'=>'','complemento'=>'','bairro'=>'','cidade'=>'','estado'=>''];
if($edicao){$st=$pdo->prepare('SELECT * FROM enderecos WHERE id=?');$st->execute([$id]);$e=$st->fetch();if(!$e)redirecionar('listar.php');}
if($_SERVER['REQUEST_METHOD']==='POST'){
 foreach($e as $k=>$v)$e[$k]=valorPost($k);
 if($e['identificacao']===''||$e['cep']===''||$e['rua']===''||$e['numero']===''||$e['bairro']===''||$e['cidade']===''||$e['estado']==='')$erro='Preencha todos os campos obrigatórios.';
 else{
  $sql=$edicao?'UPDATE enderecos SET identificacao=?,tipo=?,cep=?,rua=?,numero=?,complemento=?,bairro=?,cidade=?,estado=? WHERE id=?':'INSERT INTO enderecos(identificacao,tipo,cep,rua,numero,complemento,bairro,cidade,estado) VALUES(?,?,?,?,?,?,?,?,?)';
  $v=[$e['identificacao'],$e['tipo'],$e['cep'],$e['rua'],$e['numero'],$e['complemento'],$e['bairro'],$e['cidade'],$e['estado']];if($edicao)$v[]=$id;
  $st=$pdo->prepare($sql);$st->execute($v);redirecionar('listar.php?ok=1');
 }
}
$tituloPagina=$edicao?'Editar endereço':'Novo endereço';require __DIR__.'/../includes/header.php';?>
<h1 class="page-title mb-3"><?=$tituloPagina?></h1><?php if($erro):?><div class="alert alert-danger"><?=h($erro)?></div><?php endif;?>
<form method="post" class="card p-4"><div class="row g-3">
<div class="col-md-6"><label class="form-label required">Identificação (ex.: Depósito principal)</label><input class="form-control" name="identificacao" required value="<?=h($e['identificacao'])?>"></div>
<div class="col-md-6"><label class="form-label">Utilização</label><select class="form-select" name="tipo"><option value="origem" <?=$e['tipo']==='origem'?'selected':''?>>Origem</option><option value="destino" <?=$e['tipo']==='destino'?'selected':''?>>Destino</option><option value="ambos" <?=$e['tipo']==='ambos'?'selected':''?>>Ambos</option></select></div>
<div class="col-md-3"><label class="form-label required">CEP</label><input class="form-control" name="cep" required value="<?=h($e['cep'])?>"></div>
<div class="col-md-7"><label class="form-label required">Rua/Avenida</label><input class="form-control" name="rua" required value="<?=h($e['rua'])?>"></div>
<div class="col-md-2"><label class="form-label required">Número</label><input class="form-control" name="numero" required value="<?=h($e['numero'])?>"></div>
<div class="col-md-4"><label class="form-label">Complemento</label><input class="form-control" name="complemento" value="<?=h($e['complemento'])?>"></div>
<div class="col-md-4"><label class="form-label required">Bairro</label><input class="form-control" name="bairro" required value="<?=h($e['bairro'])?>"></div>
<div class="col-md-3"><label class="form-label required">Cidade</label><input class="form-control" name="cidade" required value="<?=h($e['cidade'])?>"></div>
<div class="col-md-1"><label class="form-label required">UF</label><input class="form-control text-uppercase" maxlength="2" name="estado" required value="<?=h($e['estado'])?>"></div>
</div><div class="mt-4"><button class="btn btn-primary">Salvar</button> <a class="btn btn-light" href="listar.php">Cancelar</a></div></form>
<?php require __DIR__.'/../includes/footer.php';?>
