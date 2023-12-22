<?php
switch ($_REQUEST["acao"]) {
   case 'salvar':
      // Verifica se o produto já existe
      $verificarProdutoSql = "SELECT * FROM produtos WHERE nomeProduto = '" . $_POST['nomeProduto'] . "'";
      $verificarProdutoRes = $banco->query($verificarProdutoSql);

      if ($verificarProdutoRes->num_rows > 0) {
         // Se o produto já existe, faça uma atualização (UPDATE)
         $atualizarSql = "UPDATE produtos SET 
                  posologia = '" . $_POST['posologia'] . "',
                  unidade = '" . $_POST['unidade'] . "'
                  WHERE nomeProduto = '" . $_POST['nomeProduto'] . "'";

         $atualizarRes = $banco->query($atualizarSql);

         if ($atualizarRes == true) {
            echo "<script>alert('Produto atualizado com sucesso!');</script>";
            echo "<script>location.href='?page=produto-listar';</script>";
         } else {
            echo "<script>alert('ERRO! :( ... Não foi possível atualizar o produto!');</script>";
            echo "<script>location.href='?page=produto-listar';</script>";
         }
      } else {
         // Se o produto não existe, faça uma inserção (INSERT)
         $inserirSql = "INSERT INTO produtos (nomeProduto, posologia, unidade) VALUES (
                  '" . $_POST['nomeProduto'] . "',
                  '" . $_POST['posologia'] . "',
                  '" . $_POST['unidade'] . "'
              )";

         $inserirRes = $banco->query($inserirSql);

         if ($inserirRes == true) {
            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            echo "<script>location.href='?page=produto-listar';</script>";
         } else {
            echo "<script>alert('ERRO! :( ... Não foi possível realizar o cadastro!');</script>";
            echo "<script>location.href='?page=produto-listar';</script>";
         }
      }
      break;
   case 'atualizar':
      $sql = "INSERT INTO produtos (
         nomeProduto, 
         posologia, 
         unidade)
       VALUES (
         '" . $_POST["nomeProduto"] . "',
         '" . $_POST["posologia"] . "',
         '" . $_POST["unidade"] . "'                
         )";
      $res = $banco->query($sql);

      if ($res == true) {
         echo "<script>alert('Cadastro realizado com sucesso!');</script>";
         echo "<script>location.href='?page=produto-listar';</script>";
      } else {
         echo "<script>alert('ERRO! :( ... Não foi possivel realizar o cadastro!');</script>";
         echo "<script>location.href='?page=produto-listar';</script>";
      }
      break;
   case 'excluir':
      $sql = "DELETE FROM produtos WHERE cod_produto=" . $_REQUEST["cod_produto"];

      $resposta = $banco->query($sql);

      if (!$resposta) {
         echo "<script>alert('Cadastro não excluido!');</script>";
         echo "<script> location.href='?page=produto-listar';</script>";
      } else {
         echo "<script>alert('Cadastro excluido com sucesso!');</script>";
         echo "<script> location.href='?page=produto-listar';</script>";
      }
      break;
}
