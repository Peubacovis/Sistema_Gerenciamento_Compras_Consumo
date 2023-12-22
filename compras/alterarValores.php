<h1 class="display-4">Altere o Valor do Produto</h1>
<form action="compras-pdf.php" method="post">
    <input type="hidden" name="cod_produto" value="<?php echo $row_produto; ?>">
    <input type="hidden" name="cod_compras" value="<?php echo $row_compras; ?>">
    <div class="mb-3">
        <label>Alterar Porcentagem</label>
        <input type="text" name="porcentagem_alteracao" class="form-control" required>
    </div>
    <button type="submit" class='btn btn-warning'>Salvar e Gerar PDF Temporário</button>
</form>