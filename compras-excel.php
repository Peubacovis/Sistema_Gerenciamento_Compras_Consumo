<?php
include("banco/banco.php");
include("./sistema/ezpdf/class.ezpdf.php");

session_start();

// Obtenha a porcentagem fornecida no formulário
$porcentagem_alteracao = isset($_POST['porcentagem_alteracao']) ? floatval($_POST['porcentagem_alteracao']) : 0;

// Valide a porcentagem (substitua com sua lógica de validação)
$porcentagem_alteracao = validar_e_sanitizar_dados($porcentagem_alteracao);

// Obtenha o valor temporário da sessão (se necessário)
$valor = isset($_SESSION['temp_valor']) ? floatval($_SESSION['temp_valor']) : 0.00;

error_reporting(E_ALL & ~E_NOTICE);

$sql = "SELECT c.fornecedor, p.nomeProduto, qtd_compras, valor, ultimaCompra, cod_produto
        FROM itens_compras i 
        RIGHT JOIN compras c ON i.id_compras = c.cod_compras 
        RIGHT JOIN produtos p ON i.id_produto = p.cod_produto
        ORDER BY nomeProduto ASC";

$resultadoConsulta = $banco->query($sql);

if (!$resultadoConsulta) {
    die("Erro na consulta: " . $banco->error);
}

$data = array();

while ($row = $resultadoConsulta->fetch_assoc()) {
    // Aplique a porcentagem ao valor do produto
    $valor_alterado = $row['valor'] * (1 + $porcentagem_alteracao / 100);

    $linha = array(
        'Codigo' => $row['cod_produto'],
        'Produto' => $row['nomeProduto'],
        'Fornecedor' => $row['fornecedor'],
        'Quantidades Compradas' => $row['qtd_compras'],
        'Valor' => number_format($valor_alterado, 2, ',', ''), // Formate o valor aqui
    );
    $data[] = $linha;
}

$totalValores = array_sum(array_column($data, 'Valor'));
$totalCompras = array_sum(array_column($data, 'Quantidades Compradas'));

foreach ($data as &$linha) {
    $porcentagem = ($linha['Valor'] / $totalValores) * 100;
    $linha['Porcentagem'] = number_format($porcentagem, 2) . '%';
}

$linhaTotal = array(
    'Codigo' => 'Total:',
    'Produto' => '',
    'Fornecedor' => '',
    'Quantidades Compradas' => number_format($totalCompras, 1, ',', ''),
    'Valor' => number_format($totalValores, 2, ',', ''), // Formate o valor aqui
    'Porcentagem' => '100%',
);
$data[] = $linhaTotal;

// Geração do XLS
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="relatorio_produtos.xls"');
header('Cache-Control: max-age=0');

echo '<table border="1">';
echo '<tr>';
foreach (array_keys($columns) as $column) {
    echo '<th>' . $column . '</th>';
}
echo '</tr>';

foreach ($data as $row) {
    echo '<tr>';
    foreach ($row as $cell) {
        echo '<td>' . $cell . '</td>';
    }
    echo '</tr>';
}

// Adicione as fórmulas diretamente nas células
echo '<tr>';
echo '<td colspan="3">Total:</td>';
echo '<td>=Soma(D2:D5)</td>';
echo '<td>=Soma(E2:E5)</td>';
echo '<td>=Soma(F2:F5)</td>';
echo '</tr>';

echo '</table>';

unset($_SESSION['temp_valor']);
unset($_SESSION['porcentagem_alteracao']);

function validar_e_sanitizar_dados($dados)
{
    return htmlspecialchars(trim($dados));
}
?>
