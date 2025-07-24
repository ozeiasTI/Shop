<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$consultaCategorias = mysqli_query($conexao, "SELECT * FROM categoria ORDER BY descricao ASC");

if (isset($_POST['pesquisar'])) {
    $categoria = $_POST['categoria'];
    $consultaPrdoutos = mysqli_query($conexao, "SELECT * FROM produto WHERE categoria_id LIKE '%$categoria%' AND ativo = 'Sim' AND estoque_total > 0");
} else {
    $consultaPrdoutos = mysqli_query($conexao, "SELECT * FROM produto WHERE ativo = 'Sim' AND estoque_total > 0");
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixa</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        main {
            padding: 0;
        }

        .caixa_header {
            display: flex;
            height: 6.5vh;
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
            height: 85.5vh;
            float: left;
            background-color: #1e1e2ff6;
        }

        #financeiro {
            width: 30%;
            height: 85.5vh;
            float: left;
            background-color: rgba(149, 206, 240, 1);
        }

        #categorias {
            padding: 8px;
            height: 7.3vh;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #1e1e2ff6;
        }

        .categorias-form {
            flex: 1;
            text-align: center;
        }

        .categorias-form input {
            width: 100%;
            height: 50px;
            cursor: pointer;
            background-color: white;
            font-weight: bold;
            font-size: 16px;
            border: none;
        }

        .categorias-form input:hover {
            background-color: #1e7180cb;
            color: white;
        }

        .listaPrdutos {
            border-top: 1px solid white;
            overflow-y: auto;
            height: 91.5%;
            background-color: rgba(149, 206, 240, 1);
            padding: 3px;
        }

        .produto {
            background-color: white;
            width: 19%;
            margin: 0.5%;
            height: 95px;
            float: left;
            border-radius: 5px;
            cursor: pointer;
        }

        .produto:hover {
            box-shadow: #1e7180cb 3px 3px 0px 3px;
        }

        .produto_foto {
            width: 50%;
            height: 95px;
            float: left;
            border-radius: 5px;
            padding: 2px;
        }

        .produto_info {
            text-align: center;
            margin-top: 10px;
            padding: 2px;
        }

        .header_carrinho {
            height: 7.3vh;
            display: flex;
            justify-content: space-between;
            background-color: var(--cor-principal);
            color: white;
            padding: 10px;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 30px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .header_qtd {
            display: flex;
            align-items: top;
        }

        .header_qtd p {
            height: 30px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px;
            font-size: 15px;
        }

        table {
            margin-top: 0;
            cursor: pointer;
        }

        tr,
        th,
        td {
            border: none;
        }

        .itens {
            height: 74.2vh;
            background-color: white;
            overflow-y: auto;
        }

        .finalizar {
            text-align: center;
            background-color: var(--cor-principal);
            padding: 5px;
        }
    </style>
</head>

<body>
    <?php include_once("../../components/header.php") ?>
    <?php include_once("../../components/menu.php") ?>
    <main>
        <div class="caixa_header">
            <h2 style="color: white;"> Venda</h2>
            <div>
                <a style="color: white;background-color:#1e7180cb;" href="index.php"><i class="fa-solid fa-cash-register"></i> Venda</a>
                <a style="color: white;" href="index.php"><i class="fa-solid fa-dollar-sign"></i> Caixa</a>
            </div>
        </div>
        <div id="produtos">
            <div id="categorias">
                <?php
                echo "<form action='' method='post' class='categorias-form'>";

                echo "<input type='hidden' name='categoria' value=''>";
                echo "<input type='submit' value='TODAS' name='pesquisar' title='TODAS'>";

                echo "</form>";
                while ($categorias = mysqli_fetch_assoc($consultaCategorias)) {
                    echo "<form action='' method='post' class='categorias-form'>";

                    echo "<input type='hidden' name='categoria' value='" . $categorias['id_categoria'] . "'>";
                    echo "<input type='submit' value='" . $categorias['descricao'] . "' name='pesquisar' title='" . $categorias['descricao'] . "'>";

                    echo "</form>";
                }
                ?>
            </div>
            <div class="listaPrdutos">
                <?php
                while ($produtos = mysqli_fetch_assoc($consultaPrdoutos)) {
                    echo "<div class='produto' onclick='adicionar({$produtos['id_produto']})' title='adicionar ao carrinho'>";

                    echo "<div class ='produto_foto'>";
                    if (!empty($produtos['foto'])) {
                        echo "<img style='max-height:80px;' src='../produtos/imagens/" . $produtos['foto'] . "'>";
                    } else {
                        echo "<img style='max-height:80px;' src='/Shop/img/sem-foto.png'>";
                    }
                    echo "</div>";

                    echo "<div class ='produto_info'>";
                    echo "<p>" . $produtos['nome'] . "</p>";
                    echo "<p>R$ " . $produtos['preco_venda'] . "</p>";
                    echo "</div>";

                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div id="financeiro">
            <div class="itens">
                <div class="header_carrinho">
                    <p>Carrinho</p>
                    <div class="header_qtd">
                        📦
                        <p>
                            <?php
                            if (isset($_SESSION['carrinho'])) {
                                echo count($_SESSION['carrinho']);
                            } else {
                                echo 0;
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <table>
                    <tr>
                        <th>Qtd</th>
                        <th>Nome</th>
                        <th>Unitário</th>
                        <th>Total</th>
                        <th>Excuir</th>
                    </tr>
                    <?php
                    $total = 0;
                    if (!empty($_SESSION['carrinho'])) {
                        foreach ($_SESSION['carrinho'] as $chave => $valor) {
                            echo "<tr>";
                            echo "<td>" . $valor['quantidade'] . "</td>";
                            echo "<td>" . $valor['nome'] . "</td>";
                            echo "<td>R$ " . $valor['preco'] . "</td>";
                            echo "<td>R$ " . number_format($valor['quantidade'] * $valor['preco'], 2) . "</td>";
                            echo "<td><i onclick='excluirItem({$chave})' style='color:red;' class='fa-solid fa-trash'></i></td>";
                            echo "</tr>";
                            $total += $valor['quantidade'] * $valor['preco'];
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='5'>Carrinho Vazio</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="finalizar">
                <table>
                <tr>
                    <th colspan="3">Valor total</th>
                    <td colspan="2"><?php echo "R$ " . number_format($total, 2); ?></td>
                </tr>
                </table>

                <button style="width: 40%;font-size:18px;" class="btnExcluir" onclick="limparCarrinho()">Limpar Carrinho</button>
                <button style="width: 40%;font-size:18px;" class="btnEditar">Receber e Finalizar</button>
            </div>
        </div>
        <script>
            function adicionar(id_produto) {
                window.location.href = "adcionar.php?id_produto=" + id_produto;
            }

            function excluirItem(id_produto) {
                window.location.href = "excluir.php?id_produto=" + id_produto;
            }
            function limparCarrinho(){
                window.location.href = "limpar.php";
            }
        </script>
    </main>

</body>

</html>