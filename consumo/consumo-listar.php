<h1 class="display-4">Lista de Consumo</h1>

<div class="mb-3">
    <?php

    $sql = "SELECT * 
            FROM produtos p 
            LEFT JOIN itens_consumo ic ON p.cod_produto = ic.id_produto
            LEFT JOIN consumo cs ON cs.cod_consumo = ic.id_consumo
            LEFT JOIN itens_compras i on p.cod_produto = i.id_produto
            LEFT JOIN compras c ON c.cod_compras = i.id_compras 
            ORDER BY nomeProduto ASC";

    $resultado = $banco->query($sql);
    $qtd = $resultado->num_rows;

    if ($qtd > 0) {
        echo "<p>Foi encontrado <b>$qtd</b> resultado(s).</p>";
        echo "<table class='table table-hover table-striped table-bordered'>";
        echo "<tr>";
        echo "<th>Nome Produto</th>";
        echo "<th>Ultimo Consumo</th>";
        echo "<th>Consumo por dia</th>";
        echo "<th>Estoque</th>";
        echo "</tr>";

        while ($row = $resultado->fetch_object()) {
            $nomeProduto = $row->nomeProduto;
            $dataConsumo = isset($row->dataConsumo) ? $row->dataConsumo : "N/A";
            $consumoDia = isset($row->consumoDia) ? $row->consumoDia : "N/A";
            $estoqueInicial = isset($row->estoqueInicial) ? $row->estoqueInicial : 0;
            $qtd_compras = isset($row->qtd_compras) ? $row->qtd_compras : 0;
            $estoqueFinal = $estoqueInicial + $qtd_compras;

            echo "<tr>";
            echo "<td>{$nomeProduto}</td>";
            echo "<td>{$dataConsumo}</td>";
            echo "<td>{$consumoDia}</td>";
            echo "<td>{$estoqueFinal}</td>";
            echo "</tr>";


            // Adiciona os dados ao array para o gráfico
            $dadosGrafico['labels'][] = $row->nomeProduto;
            $dadosGrafico['datasets'][0]['data'][] = $row->consumoDia;

            $dadosGrafico['media'][] = $row->consumoDia;
        }
        // Calcula a média geral dos valores
        $mediaGeral = array_sum($dadosGrafico['media']) / count($dadosGrafico['media']);
        echo "</table>";
    } else {
        echo "<p class='alert alert-danger'>Não foram encontrados resultados!</p>";
    }
    ?>
    <div class="mb-3 text-center">
        <canvas id="grafico" class="mx-auto"></canvas>
    </div>

    <p class="text-center">Média Geral do Consumo:   <?php echo number_format($mediaGeral, 2, ',', '.'); ?></p>

    <script>
        // Obtém o contexto do canvas
        var ctx = document.getElementById('grafico').getContext('2d');

        // Cria o gráfico usando Chart.js
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: <?php echo json_encode($dadosGrafico); ?>,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</div>