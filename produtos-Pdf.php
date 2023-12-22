<?php
include("banco/banco.php");
include("./sistema/ezpdf/class.ezpdf.php");

error_reporting(E_ALL & ~E_NOTICE);

$sql = "SELECT c.fornecedor, p.nomeProduto, qtd_compras, valor, ultimaCompra, cod_produto
FROM itens_compras i 
RIGHT JOIN compras c ON i.id_compras = c.cod_compras 
RIGHT JOIN produtos p ON i.id_produto = p.cod_produto
ORDER BY nomeProduto ASC";
$resultadoConsulta = $banco->query($sql);
$qtd = $resultadoConsulta->num_rows;

if (!$resultadoConsulta) {
    die("Erro na consulta: " . $banco->error);
}

$data = array();

while ($row = $resultadoConsulta->fetch_assoc()) {
    $linha = array(
        'Codigo' => $row['cod_produto'],
        'Produto' => $row['nomeProduto'],
        'Valor' => $row['valor'],
    );
    $data[] = $linha;
}
$totalValores = array_sum(array_column($data, 'Valor'));

foreach ($data as &$linha) {
    $porcentagem = ($linha['Valor'] / $totalValores) * 100;
    $linha['Porcentagem'] = number_format($porcentagem, 2) . '%';
}
$linhaTotal = array(
    'Codigo' => 'Total:',
    'Produto' => '',
    'Valor' => number_format($totalValores, 2),
    'Porcentagem' => '100%',
);
$data[] = $linhaTotal;

$pdf = new Cezpdf();
$pdf->selectFont('./sistema/ezpdf/fonts/Helvetica');
$pdf->setPreferences('utf-8', 1);

$columns = array(
    'Codigo' =>  'Codigo',
    'Produto' => 'Produto',
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

$pdf->ezStream();
