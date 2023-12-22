<?php
session_start();

require_once "banco/cadastro.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM cadastro WHERE nome = ? AND senha = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $senha);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();

        if (password_verify($senha, $row['senha'])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["nomeUsuario"] = $row['nome']; // Adiciona o nome do usuário à sessão

            header("Location: index.php");
            exit;
        }
    } else {
        $error = "Usuário ou senha incorreto!";
    }
}
?>

<!DOCTYPE html>
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
        <!-- ... (seu código de navegação) ... -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <?php
                // ... (seu código de inclusão de páginas) ...
                ?>

                <?php
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
               
