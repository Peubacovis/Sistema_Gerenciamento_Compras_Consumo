<h1 class="display-4">Editar Fornecedor</h1>
<?php
$sql = "SELECT * FROM compras WHERE cod_compras=" . $_REQUEST['cod_compras'];
$res = $banco->query($sql);
$row = $res->fetch_object();
?>

<form action="?page=salvar-fornecedor" method="post">
    <input type="hidden" name="acao" value="atualizar">
    <input type="hidden" name="cod_compras" value="<?php echo $row->cod_compras; ?>">

    <div class="mb-3">
        <label>Nome do Produto</label>
        <input type="text" name="fornecedor" class="form-control" value="<?php echo $row->fornecedor; ?>">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" onclick="location.href='?page=fornecedor-listar'" class="btn btn-secondary">Voltar</button>
    </div>
</form>