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
        'Valor' => $valor_alterado, // Use o valor alterado aqui
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
    'Quantidades Compradas' => number_format($totalCompras, 1),
    'Valor' => number_format($totalValores, 2),
    'Porcentagem' => '100%',
);
$data[] = $linhaTotal;

$pdf = new Cezpdf();
$pdf->selectFont('./sistema/ezpdf/fonts/Helvetica');
$pdf->setPreferences('utf-8', 1);

$columns = array(
    'Codigo' => 'Codigo',
    'Produto' => 'Produto',
    'Fornecedor' => 'Fornecedor',
    'Quantidades Compradas' => 'Quantidade Compradas',
    'Valor' => 'Valor',
    'Porcentagem' => 'Porcentagem',
);

$options = array(
    'width' => 550,
    'showHeadings' => 1,
    'shaded' => 2,
    'shadeCol' => array(0.9, 0.9, 0.9),
    'showLines' => 2,
);

$pdf->ezTable($data, $columns, 'Relatorio de Produtos', $options);

// Trate possíveis erros na geração do PDF
try {
    $pdf->ezStream();
} catch (Exception $e) {
    // Lidere com o erro da geração do PDF
    echo "Erro na geração do PDF: " . $e->getMessage();
}

// Limpe a porcentagem e outros dados temporários da sessão
unset($_SESSION['temp_valor']);
unset($_SESSION['porcentagem_alteracao']);

// Função para validar dados (exemplo)
function validar_e_sanitizar_dados($dados)
{
    // Implemente sua lógica de validação/sanitização aqui
    return htmlspecialchars(trim($dados));
}
?>
