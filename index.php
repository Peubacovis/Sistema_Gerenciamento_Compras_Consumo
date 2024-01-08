<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}
?>


<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Quadro de Itens</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="login.php">Agenda</a>
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
                            <li><a class="dropdown-item" href="?page=produto-listar">Listar Produtos</a></li>
                            <li><a class="dropdown-item" href="?page=produto-novo">Novo Produto</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Fornecedor
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=fornecedor-listar">Listar Fornecedor</a></li>
                            <li><a class="dropdown-item" href="?page=fornecedor-novo">Novo Fornecedor</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Consumo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=consumo-listar">Listar Consumo</a></li>
                            <li><a class="dropdown-item" href="?page=consumo-novo">Novo Consumo</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Compras
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=comprar-listar">Listar Compras</a></li>
                            <li><a class="dropdown-item" href="?page=comprar-novo">Nova Compra</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form action="logout.php" method="post">
        <input type="submit" value="Logout" class="btn btn-secondary">
    </form>

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
                    case "consumo-detalhar":
                        include("consumo/consumo-detalhes.php");
                        break;
                    case "consumo-novo":
                        include("consumo/consumo-novo.php");
                        break;
                    case "consumo-listar":
                        include("consumo/consumo-listar.php");
                        break;
                    case "consumo-editar":
                        include("consumo/consumo-editar.php");
                        break;
                    case "salvar-consumo":
                        include("consumo/salvar-consumo.php");
                        break;
                    case "fornecedor-novo":
                        include("fornecedor/fornecedor-novo.php");
                        break;
                    case "fornecedor-listar":
                        include("fornecedor/fornecedor-listar.php");
                        break;
                    case "fornecedor-editar":
                        include("fornecedor/fornecedor-editar.php");
                        break;
                    case "salvar-fornecedor":
                        include("fornecedor/salvar-fornecedor.php");
                        break;
                    case "comprar-novo":
                        include("comprar/comprar-novo.php");
                        break;
                    case "comprar-listar":
                        include("comprar/comprar-listar.php");
                        break;
                    case "comprar-editar":
                        include("comprar/comprar-editar.php");
                        break;
                    case "salvar-comprar":
                        include("comprar/salvar-comprar.php");
                        break;
                    default:
                        echo "<h1 class='display-4'>Seja bem vindo!</h1>";
                }
                ?>
            </div>
        </div>
    </div>
    
    <?php include("rodape.php"); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>