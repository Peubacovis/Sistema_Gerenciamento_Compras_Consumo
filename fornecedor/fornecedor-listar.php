<h1 class="display-4">Lista de fornecedores</h1>

<div class="mb-3">
    <?php

    $sql = "SELECT * FROM compras ORDER BY fornecedor ASC";

    $resultado = $banco->query($sql);
    $qtd = $resultado->num_rows;

    if ($qtd > 0) {
        echo "<p>Foi encontrado <b>$qtd</b> resultado(s).</p>";
        echo "<table class='table table-hover table-striped table-bordered'>";
        echo "<tr>";
        echo "<th>fornecedor</th>";       
        echo "<th>Açoes</th>";
        echo "</tr>";

        while ($row = $resultado->fetch_object()) {
            echo "<tr>";
            echo "<td>{$row->fornecedor}</td>";            
            echo "<td>
                <button onclick=\"location.href='?page=fornecedor-editar&acao=atualizar&cod_compras=" . $row->cod_compras . "';\" class='btn btn-warning'>Editar</button>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar-fornecedor&acao=excluir&cod_compras=" . $row->cod_compras . "';}else{false;}\" class='btn btn-danger'>Excluir</button>
            </td>";
            echo "</tr>";
        }
    } else {
        echo "<p class='alert alert-danger'>Não foram encontrados resultados!</p>";
    }
    ?>
</div>
