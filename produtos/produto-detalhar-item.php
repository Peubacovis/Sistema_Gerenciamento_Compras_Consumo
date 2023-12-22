<h2 class="display-4">Detalhes do Produto</h2>

<div class="mb-3">
    <?php
    include "banco/banco.php";
    

    $cod = $_REQUEST['cod'] ?? 0;
    $sql = "SELECT * 
            FROM produtos p 
            LEFT JOIN itens_consumo ic ON p.cod_produto = ic.id_produto
            LEFT JOIN consumo cs ON cs.cod_consumo = ic.id_consumo
            LEFT JOIN itens_compras i ON p.cod_produto = i.id_produto
            LEFT JOIN compras c ON c.cod_compras = i.id_compras WHERE p.cod_produto = '$cod'";

    $resultado = $banco->query($sql);
    $qtd = $resultado->num_rows;

    if (!$resultado) {
        echo "Erro na consulta ao banco de dados: " . $banco->error;
    } else {
        if ($resultado->num_rows > 0) {
            echo "<p>Foi encontrado <b>$qtd</b> resultado(s).</p>";
            echo "<table class='table table-hover table-striped table-bordered'>";
            echo "<tr>";
            echo "<th>Nome Produto</th>";
            echo "<th>Fornecedor</th>";
            echo "<th>Unidades</th>";
            echo "<th>Entrada</th>";
            echo "<th>Consumo/Posologia</th>";
            echo "<th>Ultimo Consumo</th>";
            echo "<th>Unidades Compradas</th>";
            echo "<th>Valor R$</th>";
            echo "<th>Estoque Final</th>";
            echo "</tr>";

            while ($registro = $resultado->fetch_object()) {
                echo "<tr>";
                echo "<td>$registro->nomeProduto</td>";
                echo "<td>$registro->fornecedor</td>";
                echo "<td>$registro->unidade</td>";
                echo "<td>" . date("d/m/y", strtotime($registro->ultimaCompra)) . "</td>";
                echo "<td>$registro->consumoDia</td>";
                echo "<td>" . date("d/m/y", strtotime($registro->dataConsumo)) . "</td>";
                echo "<td>$registro->qtd_compras</td>";
                echo "<td>" . number_format($registro->valor, 2, ',', '.') . "</td>";
                $estoqueFinal = $registro->estoqueInicial + $registro->qtd_compras;
                echo "<td>$estoqueFinal</td>";
                echo "</tr>";
            }
        } else {
            echo "<p class='alert alert-danger'>Não foi encontrado resultados!</p>";
        }
    }
    ?>
</div>
<div class="mb-3">
    <button onclick="location.href='?page=produto-listar'" class="btn btn-secondary">Voltar</button>
</div>