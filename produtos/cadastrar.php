<?php
require_once __DIR__.'/../config/conexao.php'; require_once __DIR__.'/../config/funcoes.php';
$id = 0; $edicao = $id > 0; $erro = '';
$p = ['codigo'=>'','nome'=>'','descricao'=>'','peso'=>'0','valor'=>'0','quantidade'=>'0'];
if ($edicao) { $st=$pdo->prepare('SELECT * FROM produtos WHERE id=?'); $st->execute([$id]); $p=$st->fetch(); if(!$p) redirecionar('listar.php'); }
if ($_SERVER['REQUEST_METHOD']==='POST') {
    foreach($p as $k=>$v) $p[$k]=valorPost($k);
    if($p['codigo']==='' || $p['nome']==='') $erro='Preencha o código e o nome do produto.';
    else {
        try {
            if($edicao) $sql='UPDATE produtos SET codigo=?,nome=?,descricao=?,peso=?,valor=?,quantidade=? WHERE id=?';
            else $sql='INSERT INTO produtos(codigo,nome,descricao,peso,valor,quantidade) VALUES(?,?,?,?,?,?)';
            $valores=[$p['codigo'],$p['nome'],$p['descricao'],$p['peso'],$p['valor'],$p['quantidade']];
            if($edicao) $valores[]=$id;
            $st=$pdo->prepare($sql); $st->execute($valores); redirecionar('listar.php?ok=1');
        } catch(PDOException $e) { $erro='Não foi possível salvar. Verifique se o código já está cadastrado.'; }
    }
}
$tituloPagina=$edicao?'Editar produto':'Novo produto'; require __DIR__.'/../includes/header.php'; ?>
<h1 class="page-title mb-3"><?=$tituloPagina?></h1><?php if($erro):?><div class="alert alert-danger"><?=h($erro)?></div><?php endif;?>
<form method="post" class="card p-4"><div class="row g-3">
<div class="col-md-4"><label class="form-label required">Código</label><input class="form-control" name="codigo" required value="<?=h($p['codigo'])?>"></div>
<div class="col-md-8"><label class="form-label required">Nome</label><input class="form-control" name="nome" required value="<?=h($p['nome'])?>"></div>
<div class="col-12"><label class="form-label">Descrição</label><textarea class="form-control" name="descricao"><?=h($p['descricao'])?></textarea></div>
<div class="col-md-4"><label class="form-label">Peso (kg)</label><input class="form-control" type="number" step="0.01" min="0" name="peso" value="<?=h($p['peso'])?>"></div>
<div class="col-md-4"><label class="form-label">Valor (R$)</label><input class="form-control" type="number" step="0.01" min="0" name="valor" value="<?=h($p['valor'])?>"></div>
<div class="col-md-4"><label class="form-label">Quantidade em estoque</label><input class="form-control" type="number" min="0" name="quantidade" value="<?=h($p['quantidade'])?>"></div>
</div><div class="mt-4"><button class="btn btn-primary">Salvar</button> <a class="btn btn-light" href="listar.php">Cancelar</a></div></form>
<?php require __DIR__.'/../includes/footer.php'; ?>
