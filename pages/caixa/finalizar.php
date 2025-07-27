<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}
if (!isset($_SESSION['carrinho']) or empty($_SESSION['carrinho'])) {
    header("Location: index.php");
    exit;
} else {
    //Variaveis
    $tipoDesconto = $_POST['Tipodesconto'];
    $desconto = $_POST['desconto'];
    $formaPagamento = $_POST['formaPagamento'];
    $cliente = $_POST['cliente'];
    $parcelas = $_POST['parcelas'];

    //Inicia total
    $total = 0;

    //percorre sessão para pegar total da compra
    foreach ($_SESSION['carrinho'] as $chave => $valor) {
        $total += $valor['quantidade'] * $valor['preco'];
    }
    //Registro
    $consultaRegistro = mysqli_query($conexao, "SELECT registro FROM vendas ORDER BY registro DESC LIMIT 1");
    if (mysqli_num_rows($consultaRegistro) > 0) {
        $linharegistro = mysqli_fetch_assoc($consultaRegistro);
        $registro = $linharegistro['registro'] + 1;
    } else {
        $registro = 1;
    }
    //Desconto
    if ($desconto > 0) {
        if ($tipoDesconto == '%') {
            $desconto = ($total * $desconto) / 100;
            $total -= $desconto;
        } else {
            $total -= $desconto;
        }
    }

    foreach ($_SESSION['carrinho'] as $chave => $valor) {
        $produto_id = $valor['id'];
        $quantidade = $valor['quantidade'];
        $valor_unitario = $valor['preco'];
        $valor_total = $valor_unitario * $quantidade;

        $vendas = mysqli_query($conexao, "INSERT INTO vendas(registro,produto_id,quantidade,valor_unitario,valor_total,cliente_id,desconto)VALUES($registro,$produto_id,$quantidade,$valor_unitario,$valor_total,$cliente,$desconto)");

        $estoque = mysqli_query($conexao, "UPDATE produto SET estoque_total = estoque_total - $quantidade WHERE id_produto = $produto_id");
    }

    if ($formaPagamento == 'Crediário') {
        $valor_parcela = $total / $parcelas;
        $dataInicial = new DateTime();
        $dataInicial->modify("+1 month");
        for ($i = 0; $i < $parcelas; $i++) {
            $dataParcela = clone $dataInicial;
            $dataParcela->modify("+{$i} month");
            $dataFormatada = $dataParcela->format("Y-m-d");

            mysqli_query($conexao, "INSERT INTO contas (descricao_conta, valor, tipo, status_conta, data_acerto, forma_acerto,identificador)
                                    VALUES ('Compra Crediário', $valor_parcela, 'Entrada', 'Aberta', '$dataFormatada', '$formaPagamento', $cliente)");
        }
    } else {
        mysqli_query($conexao, "INSERT INTO caixa(valor,tipo,descricao,referencia)VALUES($total,'Entrada','Pagamento de Compra Crediário','Vendas')");
    }

    unset($_SESSION['carrinho']);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        main {
            padding: 0;
        }

        .caixa_header {
            display: flex;
            height: 6.9vh;
            justify-content: space-between;
            align-items: center;
            background-color: var(--cor-principal);
            padding: 10px;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 20px;

        }

        .caixa_header a {
            color: white;
            font-size: 22px;
            text-decoration: none;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            border: 1px solid white;
            padding: 8px;
        }

        .caixa_header a:hover {
            background-color: #2b788694;
        }

        #produtos {
            width: 70%;
            height: 85vh;
            float: left;
            background-color: #1e1e2ff6;
        }
    </style>
</head>

<body>
    <?php include_once("../../components/header.php") ?>
    <?php include_once("../../components/menu.php") ?>
    <main>
        <div class="caixa_header">
            <h2 style="color: white;"> Finalizar Compra</h2>
            <div>
                <a style="color: white;" href="index.php"><i class="fa-solid fa-cash-register"></i> Venda</a>
            </div>
        </div>
    </main>

</body>

</html>