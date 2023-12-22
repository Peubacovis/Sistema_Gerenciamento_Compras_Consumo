<?php
switch ($_REQUEST["acao"]) {
    case 'salvar':
        if (isset($_POST['produtos'], $_POST['consumoDia'], $_POST['dataConsumo'])) {
            $produto = $_POST['produtos'];
            $consumoDia = $_POST['consumoDia'];
            $dataConsumo = $_POST['dataConsumo'];

           
            $sql_consumo = "INSERT INTO consumo (dataConsumo) VALUES ('$dataConsumo')";
            $res_consumo = $banco->query($sql_consumo);

            if ($res_consumo === TRUE) {
                $id_consumo = $banco->insert_id;  

                $sql_itens_consumo = "INSERT INTO itens_consumo (id_produto, id_consumo, consumoDia)
                              VALUES ('$produto', '$id_consumo', '$consumoDia')";
                $res_itens_consumo = $banco->query($sql_itens_consumo);

                if ($res_itens_consumo === TRUE) {
                    echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                    echo "<script>location.href='?page=consumo-listar';</script>";
                } else {
                    $banco->query("DELETE FROM consumo WHERE cod_consumo = $id_consumo");

                    echo "<script>alert('ERRO! :( ... Não foi possível realizar o cadastro!');</script>";
                    echo "<script>location.href='?page=consumo-listar';</script>";
                }
            } else {
                echo "<script>alert('ERRO! :( ... Não foi possível realizar o cadastro!');</script>";
                echo "<script>alert('Erro no banco de dados: " . $banco->error . "');</script>";
                echo "<script>location.href='?page=consumo-listar';</script>";
            }
        } else {
            echo "<script>alert('Erro! Certifique-se de preencher todos os campos obrigatórios.');</script>";
            echo "<script>location.href='?page=consumo-listar';</script>";
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
        $sql = "DELETE FROM consumo WHERE cod_consumo =" . $_REQUEST["cod_consumo"];

        $resposta = $banco->query($sql);

        if (!$resposta) {
            echo "<script>alert('Consumo não excluido!');</script>";
            echo "<script> location.href='?page=consumo-listar';</script>";
        } else {
            echo "<script>alert('Consumo excluido com sucesso!');</script>";
            echo "<script> location.href='?page=consumo-listar';</script>";
        }
        break;
}
