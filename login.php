<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "banco/cadastro.php";

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha FROM cadastro WHERE nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($senha, $row['senha'])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"] = $row['nome'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Senha incorreta";
        }
    } else {
        $error = "Nome de usuário não encontrado";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login do Usuário</title>
    <link rel="stylesheet" href="login.css">
<body>
<h1>login do Usuário</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="id" value="salvar">
        <div>
            <label>Nome</label>
            <input type="text" name="nome" placeholder="Digite o seu nome" required>
        </div>
        <div>
            <label>Senha</label>
            <input type="password" name="senha" placeholder="Digite a sua senha" required>
        </div>
        <input type="submit" value="Logar">
    </form>
   
    <br>
    <a href="cadastro_usuario.php">Cadastrar novo usuário?</a>
</body>
</html>