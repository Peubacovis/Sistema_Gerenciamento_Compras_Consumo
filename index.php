<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quadro de Itens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Acompanhamento</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produtos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=produto-listar">Listar</a></li>
                            <li><a class="dropdown-item" href="?page=produto-novo">Cadastrar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Consumo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=consumo-listar">Listar</a></li>
                            <li><a class="dropdown-item" href="?page=consumo-novo">Cadastrar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Compras
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=compras-listar">Listar</a></li>
                            <li><a class="dropdown-item" href="?page=compras-novo">Cadastrar</a></li>
                        </ul>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Fornecedor
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=fornecedor-listar">Listar</a></li>
                            <li><a class="dropdown-item" href="?page=fornecedor-novo">Cadastrar</a></li>
                        </ul>
                    </li>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <?php
                include("banco/banco.php");
                switch (@$_REQUEST["page"]) {
                    case "produto-listar":
                        include("produtos/produto-listar.php");
                        break;
                    case "produto-novo":
                        include("produtos/produto-novo.php");
                        break;
                    case "produto-detalhar-item":
                        include("produtos/produto-detalhar-item.php");
                        break;
                    case "produto-editar":
                        include("produtos/produto-editar.php");
                        break;
                    case "salvar":
                        include("produtos/salvar-produto.php");
                        break;
                    case "consumo-detalhes":
                        include("consumo/consumo-detalhes.php");
                        break;
                    case "consumo-novo":
                        include("consumo/consumo-novo.php");
                        break;
                    case "consumo-listar":
                        include("consumo/consumo-listar.php");
                        break;
                    case "fornecedor-listar":
                        include("fornecedor/fornecedor-listar.php");
                        break;
                    case "fornecedor-detalhar":
                        include("fornecedor/fornecedor-detalhar.php");
                        break;
                    case "fornecedor-novo":
                        include("fornecedor/fornecedor-novo.php");
                        break;
                    case "fornecedor-editar":
                        include("fornecedor/fornecedor-editar.php");
                        break;
                    case "salvar-fornecedor":
                        include("fornecedor/salvar-fornecedor.php");
                        break;
                    case "consumo-editar":
                        include("consumo/consumo-editar.php");
                        break;
                    case "salvar-consumo":
                        include("consumo/salvar-consumo.php");
                        break;
                    case "compras-editar":
                        include("compras/compras-editar.php");
                        break;
                    case "compras-listar":
                        include("compras/compras-listar.php");
                        break;
                    case "compras-novo":
                        include("compras/compras-novo.php");
                        break;
                    case "salvar-compras":
                        include("compras/salvar-compras.php");
                        break;
                    case "alterar-valores":
                        include("compras/alterarValores.php");
                        break;
                    default:
                        echo "<h1 class='display-4'>Seja bem vindo!</h1>";
                }
                ?>
               <?php
                // Consulta SQL para obter os dados do banco de dados
                $sql = "SELECT c.fornecedor, p.nomeProduto, qtd_compras, valor, ultimaCompra 
                FROM itens_compras i 
                RIGHT JOIN compras c ON i.id_compras = c.cod_compras 
                RIGHT JOIN produtos p ON i.id_produto = p.cod_produto
                ORDER BY nomeProduto ASC";

                $resultado = $banco->query($sql);

                $dadosGrafico = [
                    'labels' => [],
                    'datasets' => [
                        [
                            'label' => 'Quantidade Comprada',
                            'data' => [],
                            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                            'borderColor' => 'rgba(75, 192, 192, 1)',
                            'borderWidth' => 1
                        ],
                        [
                            'label' => 'Valor (R$)',
                            'data' => [],
                            'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                            'borderColor' => 'rgba(255, 99, 132, 1)',
                            'borderWidth' => 1
                        ]
                    ]
                ];

                while ($row = $resultado->fetch_assoc()) {
                    $dadosGrafico['labels'][] = $row['nomeProduto'];
                    $dadosGrafico['datasets'][0]['data'][] = $row['qtd_compras'];
                    $dadosGrafico['datasets'][1]['data'][] = $row['valor'];
                }
                ?>
                

                <?php
                // Verifica se está na página inicial (index.php) antes de exibir o gráfico
                if (@$_REQUEST["page"] == "index" || empty(@$_REQUEST["page"])) {
                ?>
                    <h2>Grafico Geral</h2>
                    <!-- Seção de gráfico -->
                    <canvas id="graficoBarras" width="1000" height="300"></canvas>

                    <div>
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            echo "<p>Bem-vindo, " . $_SESSION["nomeUsuario"] . "!</p>";
                        }
                        ?>
                    </div>

                    <script>
                        var ctx = document.getElementById('graficoBarras').getContext('2d');

                        var myChart = new Chart(ctx, {
                            type: 'bar',
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
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>