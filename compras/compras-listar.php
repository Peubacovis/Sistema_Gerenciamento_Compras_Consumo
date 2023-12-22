<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lista de Compras</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1 class="display-4">Lista de Compras</h1>

    <div class="mb-3">
        <?php
        // Seu código de conexão com o banco de dados (assumindo que $banco esteja definido)
        $sql = "SELECT c.fornecedor, p.nomeProduto, qtd_compras, valor, ultimaCompra 
            FROM itens_compras i 
            RIGHT JOIN compras c ON i.id_compras = c.cod_compras 
            RIGHT JOIN produtos p ON i.id_produto = p.cod_produto
            ORDER BY nomeProduto ASC";

        $resultado = $banco->query($sql);
        $qtd = $resultado->num_rows;

        if ($qtd > 0) {
            echo "<p>Foi encontrado <b>$qtd</b> resultado(s).</p>";
            echo "<div class='mb-3'>";
            echo "<button type='button' onclick='gerarPDF()' class='btn btn-primary'>PDF</button>";
            echo "<button type='button' onclick='redirectToComprasExcel()' class='btn btn-primary' id='excelButton'>Excel</button>";
            echo "</div>";

            echo "<table class='table table-hover table-striped table-bordered'>";
            echo "<tr>";
            echo "<th>Fornecedor</th>";
            echo "<th>Produto</th>";
            echo "<th>Quantidade Compradas</th>";
            echo "<th>Ultima Compra</th>";
            echo "<th>Valor R$</th>";
            echo "</tr>";

            $dadosGrafico = array('labels' => array(), 'datasets' => array(), 'media' => array());

            while ($row = $resultado->fetch_object()) {
                $fornecedor = $row->fornecedor;
                $nomeproduto = $row->nomeProduto;
                $qtd_compras = $row->qtd_compras;
                $ultimaCompra = $row->ultimaCompra;
                $valor = $row->valor;

                echo "<tr>";
                echo "<td>$row->fornecedor</td>";
                echo "<td>$row->nomeProduto</td>";
                echo "<td>$row->qtd_compras</td>";
                echo "<td>$row->ultimaCompra</td>";
                echo "<td>$row->valor</td>";
                echo "</tr>";

                // Adiciona os dados ao array para o gráfico
                $dadosGrafico['labels'][] = $row->nomeProduto;
                $dadosGrafico['datasets'][0]['data'][] = $row->valor;

                // Calcula a média dos valores
                $dadosGrafico['media'][] = $row->valor;
            }

            // Calcula a média geral dos valores
            $mediaGeral = array_sum($dadosGrafico['media']) / count($dadosGrafico['media']);
            echo "</table>";
        } else {
            echo "<p class='alert alert-danger'>Não foram encontrados resultados!</p>";
        }
        ?>
    </div>

    <div class="mb-3 text-center">
        <canvas id="grafico" class="mx-auto"></canvas>
    </div>

    <p class= "text-center">Média Geral dos Valores: R$ <?php echo number_format($mediaGeral, 2, ',', '.'); ?></p>

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

    <script>
        function gerarPDF() {
            let resposta = confirm("Você deseja gerar um PDF?");

            if (resposta) {
                let alterarPdf = confirm("Deseja alterar valores da planilha Compras?");

                if (alterarPdf) {
                    location.href = '?page=alterar-valores';
                } else {
                    location.href = 'compras-pdfNalterado.php';
                }
            } else {
                alert("PDF não gerado.");
            }
        }
    </script>
    <script>
        function redirectToComprasExcel() {
            window.location.href = 'compras-excel.php';
        }
    </script>

</body>

</html>
