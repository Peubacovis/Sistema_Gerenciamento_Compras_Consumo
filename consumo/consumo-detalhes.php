<h2 class="display-4">Detalhes do Consumo   </h2>

<div class="mb-3">
    <?php    
    $sql = "SELECT  * 
            FROM consumo
            LEFT JOIN itens_consumo ic ON p.cod_produto = ic.id_produto
            LEFT JOIN consumo cs ON cs.cod_consumo = ic.id_consumo";

    $resultado = $banco->query($sql);
    $qtd = $resultado->num_rows;

        if ($qtd > 0) {
            echo "<p>Foi encontrado <b>$qtd</b> resultado(s).</p>";
            echo "<table class='table table-hover table-striped table-bordered'>";
            echo "<tr>";
            echo "<th>Consumo Dia</th>";
            echo "<th>Ultimo Consumo</th>";
            echo "</tr>";
            while ($registro = $resultado->fetch_object()) {
                echo "<tr>";
                echo "<td>$registro->consumoDia</td>";
                echo "<td>" . date("d/m/y", strtotime($registro->dataConsumo)) . "</td>";
                echo "<td>$registro->fornecedor</td>";
                echo "<td>$registro->qtd_compras</td>";
            }
        } else {
            echo "<p class='alert alert-danger'>Não foi encontrado resultados!</p>";
        }    
    ?>
</div>
