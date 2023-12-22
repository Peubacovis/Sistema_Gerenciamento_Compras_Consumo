<?php
switch ($_REQUEST["acao"]) {
   case 'salvar':
      $sql = "INSERT INTO compras (fornecedor)
      VALUES ('" . $_POST["fornecedor"] . "')";
      $res = $banco->query($sql);

      if ($res == true) {
         echo "<script>alert('Cadastro realizado com sucesso!');</script>";
         echo "<script>location.href='?page=fornecedor-listar';</script>";
      } else {
         echo "<script>alert('ERRO! :( ... Não foi possivel realizar o cadastro!');</script>";
         echo "<script>location.href='?page=fornecedor-listar';</script>";
      }
      break;
   case 'atualizar':
      $sql = "UPDATE compras SET fornecedor = '" . $_POST["fornecedor"] . "' WHERE cod_compras = " . $_POST["cod_compras"];

      $res = $banco->query($sql);


      if ($res == true) {
         echo "<script>alert('Cadastro editado com sucesso!');</script>";
         echo "<script>location.href='?page=fornecedor-listar';</script>";
      } else {
         echo "<script>alert('ERRO! :( ... Não foi possivel realizar a edição!');</script>";
         echo "<script>location.href='?page=fornecedor-listar';</script>";
      }
      break;
   case 'excluir':
      // Verifica se o parâmetro cod_compras foi fornecido
      if (isset($_REQUEST["cod_compras"])) {
         $cod_compras = $_REQUEST["cod_compras"];

         // Exclui itens_compras relacionados
         $stmt_delete_itens = $banco->prepare("DELETE FROM itens_compras WHERE id_compras = ?");
         $stmt_delete_itens->bind_param("i", $cod_compras);
         $resposta_delete_itens = $stmt_delete_itens->execute();
         $stmt_delete_itens->close();

         if (!$resposta_delete_itens) {
            echo "<script>alert('Erro ao excluir itens_compras: " . $stmt_delete_itens->error . "');</script>";
         }

         // Exclui compra
         $stmt_delete_compra = $banco->prepare("DELETE FROM compras WHERE cod_compras = ?");
         $stmt_delete_compra->bind_param("i", $cod_compras);
         $resposta_delete_compra = $stmt_delete_compra->execute();
         $stmt_delete_compra->close();

         if (!$resposta_delete_compra) {
            echo "<script>alert('Erro ao excluir compra: " . $stmt_delete_compra->error . "');</script>";
         } else {
            echo "<script>alert('Cadastro excluído com sucesso!');</script>";
         }
      } else {
         echo "<script>alert('Parâmetro cod_compras não fornecido!');</script>";
      }

      echo "<script>location.href='?page=fornecedor-listar';</script>";
      break;
}
