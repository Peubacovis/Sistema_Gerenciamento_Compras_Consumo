<h1 class="display-4">Cadastrar Consumo</h1>

<div class="container mt-5">
    <form action="?page=salvar-consumo" method="POST">
        <input type="hidden" name="acao" value="salvar">
        <div class="mb-3">
            <label for="produtos" class="form-label">Selecione o Produto:</label>
            <select name="produtos" id="produtos" class="form-select" required>
                <?php
                $sql_produtos = "SELECT cod_produto, nomeProduto FROM produtos";
                $result_produtos = $banco->query($sql_produtos);
                if ($result_produtos->num_rows > 0) {
                    while ($row_produto = $result_produtos->fetch_assoc()) {
                        echo "<option value='" . $row_produto['cod_produto'] . "'>" . $row_produto['nomeProduto'] . "</option>";
                    }
                } else {
                    echo "<option value='' disabled>Nenhum produto disponível</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="consumoDia" class="form-label">Quantidade Consumida:</label>
            <input type="number" name="consumoDia" id="consumoDia" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="dataConsumo" class="form-label">Data do Consumo:</label>
            <input type="date" name="dataConsumo" id="dataConsumo" class="form-control" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Registrar Consumo</button>
        </div>
    </form>
</div>