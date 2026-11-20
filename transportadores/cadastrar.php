<?php
require_once __DIR__.'/../config/conexao.php';require_once __DIR__.'/../config/funcoes.php';
$id=0;$edicao=$id>0;$erro='';$t=['nome'=>'','documento'=>'','telefone'=>'','email'=>'','veiculo'=>'','placa'=>'','status'=>'ativo'];
if($edicao){$st=$pdo->prepare('SELECT * FROM transportadores WHERE id=?');$st->execute([$id]);$t=$st->fetch();if(!$t)redirecionar('listar.php');}
if($_SERVER['REQUEST_METHOD']==='POST'){foreach($t as $k=>$v)$t[$k]=valorPost($k);if($t['nome']===''||$t['documento']==='')$erro='Informe o nome e o documento.';
else{$sql=$edicao?'UPDATE transportadores SET nome=?,documento=?,telefone=?,email=?,veiculo=?,placa=?,status=? WHERE id=?':'INSERT INTO transportadores(nome,documento,telefone,email,veiculo,placa,status) VALUES(?,?,?,?,?,?,?)';$v=array_values($t);if($edicao)$v[]=$id;$st=$pdo->prepare($sql);$st->execute($v);redirecionar('listar.php?ok=1');}}
$tituloPagina=$edicao?'Editar transportador':'Novo transportador';require __DIR__.'/../includes/header.php';?>
<h1 class="page-title mb-3"><?=$tituloPagina?></h1><?php if($erro):?><div class="alert alert-danger"><?=h($erro)?></div><?php endif;?>
<form method="post" class="card p-4"><div class="row g-3">
<div class="col-md-6"><label class="form-label required">Nome/Razão social</label><input class="form-control" name="nome" required value="<?=h($t['nome'])?>"></div>
<div class="col-md-6"><label class="form-label required">CPF/CNPJ</label><input class="form-control" name="documento" required value="<?=h($t['documento'])?>"></div>
<div class="col-md-4"><label class="form-label">Telefone</label><input class="form-control" name="telefone" value="<?=h($t['telefone'])?>"></div>
<div class="col-md-4"><label class="form-label">E-mail</label><input class="form-control" type="email" name="email" value="<?=h($t['email'])?>"></div>
<div class="col-md-4"><label class="form-label">Veículo</label><input class="form-control" name="veiculo" placeholder="Ex.: Caminhão baú" value="<?=h($t['veiculo'])?>"></div>
<div class="col-md-4"><label class="form-label">Placa</label><input class="form-control" name="placa" maxlength="10" value="<?=h($t['placa'])?>"></div>
<div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status"><option value="ativo" <?=$t['status']==='ativo'?'selected':''?>>Ativo</option><option value="inativo" <?=$t['status']==='inativo'?'selected':''?>>Inativo</option></select></div>
</div><div class="mt-4"><button class="btn btn-primary">Salvar</button> <a class="btn btn-light" href="listar.php">Cancelar</a></div></form><?php require __DIR__.'/../includes/footer.php';?>
