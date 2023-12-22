<h1 class="display-4">Nova Compra</h1>

<div class="mb-3">
    <button type="button" onclick="location.href='?page=fornecedor-novo'" class="btn btn-primary">Novo Fornecedor</button>
    <button type="button" onclick="location.href='?page=produto-novo'" class="btn btn-primary">Novo Produto</button>
</div>

<form action="?page=salvar-compras" method="POST">
    <input type="hidden" name="acao" value="salvar">
    <input type="hidden" name="cod_produto" value="<?php echo $row_produto; ?>">
    <input type="hidden" name="cod_compras" value="<?php echo $row_compras; ?>">
    
    <div class="mb-3">
        <label>Selecione o Produto</label>
        <select name="nomeProduto" class="form-control" required>
            <option> - Escolha o Produto -</option>
            <?php
            $sql_produtos = "SELECT * FROM produtos";
            $result_produtos = $banco->query($sql_produtos);

            if ($result_produtos->num_rows > 0) {
                while ($row_produto = $result_produtos->fetch_assoc()) {
                    echo "<option value='" . $row_produto['cod_produto'] . "'>" . $row_produto['nomeProduto'] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhum produto disponível</option>";
            }
            ?>
        </select> 
    </div>

    <div class="mb-3">
        <label>Selecione o Fornecedor</label>
        <select name="fornecedor" class="form-control" required>
            <option> - Escolha o Fornecedor -</option>
            <?php
            $sql_compras = "SELECT * FROM compras";
            $result_compras = $banco->query($sql_compras);

            if ($result_compras->num_rows > 0) {
                while ($row_compras = $result_compras->fetch_assoc()) {
                    echo "<option value='" . $row_compras['cod_compras'] . "'>" . $row_compras['fornecedor'] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhum produto disponível</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Valor do Produto</label>
        <input type="number" name="valor" class="form-control" step="any" required>
    </div>

    <div class="mb-3">
        <label>Quantidade Comprada</label>
        <input type="number" name="qtd_compras" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Data da Compra</label>
        <input type="date" name="ultimaCompra" class="form-control" required>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-success">Registrar Compra</button>        
    </div>
</form>