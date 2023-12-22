<h1 class="display-4">Lista de Produtos</h1>

<div class="mb-3">
    <?php

    $sql = "SELECT * FROM produtos ORDER BY nomeProduto ASC";

    $resultado = $banco->query($sql);
    $qtd = $resultado->num_rows;

    if ($qtd > 0) {
        echo "<p>Foi encontrado <b>$qtd</b> resultado(s).</p>";
        echo "<table class='table table-hover table-striped table-bordered'>";
        echo "<tr>";
        echo "<th>Produto</th>";       
        echo "<th>Açoes</th>";
        echo "</tr>";

        while ($row = $resultado->fetch_object()) {
            echo "<tr>";
            echo "<td><a href='?page=produto-detalhar-item&cod={$row->cod_produto}'>{$row->nomeProduto}</a></td>";            
            echo "<td>
                <button onclick=\"location.href='?page=produto-editar&acao=atualizar&cod_produto=" . $row->cod_produto . "';\" class='btn btn-warning'>Editar</button>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar&acao=excluir&cod_produto=" . $row->cod_produto . "';}else{false;}\" class='btn btn-danger'>Excluir</button>           
            </td>";
            echo "</tr>";
        }
    } else {
        echo "<p class='alert alert-danger'>Não foram encontrados resultados!</p>";
    }
    ?>
    <button onclick="location.href='produtos-pdf.php';" class='btn btn-warning'>Gerar PDF</button>
</div>
