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

$consultaClientes = mysqli_query($conexao, "SELECT * FROM clientes WHERE id_cliente != 1 ORDER BY nome ASC");
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
            font-size: 20px;
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

        #financeiro {
            width: 30%;
            height: 85vh;
            float: left;
            background-color: rgba(149, 206, 240, 1);
        }

        #categorias {
            overflow-x: auto;
            overflow-y: auto;
            padding: 7px;
            height: 7.3vh;
            width: 100%;
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
            height: 35px;
            cursor: pointer;
            background-color: white;
            font-weight: bold;
            font-size: 15px;
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
            justify-content: center;
        }

        .produto {
            background-color: white;
            width: 210px;
            margin: 0.5%;
            height: 95px;
            float: left;
            border-radius: 5px;
            cursor: pointer;
            padding: 3px;
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
            height: 72.2vh;
            background-color: white;
            overflow-y: auto;
        }

        .finalizar {
            height: 13vh;
            text-align: center;
            background-color: var(--cor-principal);
        }

        .sombracarrinho {
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.158);
            position: fixed;
            top: 0;
            display: none;
        }

        .modalcarrinho {
            position: absolute;
            top: 50%;
            left: 40%;
            transform: translate(-50%, -50%);
            background-color: var(--cor-branco);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 50%;
            height: 400px;
        }

        .opcoes {
            display: flex;
        }

        .opcoes i:hover {
            background-color: #21DB88;
        }

        .opcoes i {
            margin-right: 8px;
            margin-left: 8px;
            background-color: cadetblue;
            color: white;
            padding: 2px;
            border-radius: 50%;
            font-size: 15px;
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
                <a style="color: white;" href="modelo.php"><i class="fa-solid fa-dollar-sign"></i> Modelo</a>
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
                    $id = $produtos['id_produto'];
                    $estoque = $produtos['estoque_total'];
                    $quantidadeNoCarrinho = 0;

                    // Verifica se o produto já está no carrinho
                    if (isset($_SESSION['carrinho'])) {
                        foreach ($_SESSION['carrinho'] as $item) {
                            if ($item['id'] == $id) {
                                $quantidadeNoCarrinho = $item['quantidade'];
                                break;
                            }
                        }
                    }

                    // Só exibe se ainda há estoque disponível
                    if ($quantidadeNoCarrinho < $estoque) {
                        echo "<div class='produto' onclick='adicionar({$id})' title='adicionar ao carrinho'>";

                        echo "<div class='produto_foto'>";
                        if (!empty($produtos['foto'])) {
                            echo "<img style='max-height:80px;' src='../produtos/imagens/" . $produtos['foto'] . "'>";
                        } else {
                            echo "<img style='max-height:80px;' src='/Shop/img/sem-foto.png'>";
                        }
                        echo "</div>";

                        echo "<div class='produto_info'>";
                        echo "<p>" . htmlspecialchars($produtos['nome']) . "</p>";
                        echo "<p>R$ " . number_format($produtos['preco_venda'], 2, ',', '.') . "</p>";
                        echo "</div>";

                        echo "</div>";
                    }
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
                            $itens_carrinho = 0;
                            if (isset($_SESSION['carrinho']) and !empty($_SESSION['carrinho'])) {
                                foreach ($_SESSION['carrinho'] as $chave => $valor) {
                                    $itens_carrinho += $valor['quantidade'];
                                }
                                echo $itens_carrinho;
                            } else {
                                echo $itens_carrinho;
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
                    if (!empty($_SESSION['mensagem'])) {
                        echo "<tr><td colspan='5' style='color:red;'>" . $_SESSION['mensagem'] . "</td></tr>";
                        unset($_SESSION['mensagem']);
                    }
                    ?>
                    <?php
                    $total = 0;
                    if (!empty($_SESSION['carrinho'])) {
                        foreach ($_SESSION['carrinho'] as $chave => $valor) {
                            echo "<tr>";
                            echo "<td class='opcoes'><i onclick='diminuir({$chave})' class='fa-solid fa-minus'></i> " . $valor['quantidade'] . " <i onclick='aumentar({$chave})' class='fa-solid fa-plus'></i></td>";
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
                <?php
                if (!empty($_SESSION['carrinho'])) {
                    echo "<button style='width: 40%;font-size:18px;' class='btnExcluir' onclick='limparCarrinho()'>🧹 Limpar </button>";
                    echo "<button style='width: 40%;font-size:18px;' class='btnEditar' onclick='receber()'>✅ Receber</button>";
                }
                ?>

            </div>
        </div>

        <div class="sombracarrinho">
            <div class="modalcarrinho">
                <div class="cliente">
                    <div style="display: flex;justify-content: space-between">
                        <?php
                        echo "<h3 style='margin-top: 5px;padding-left:25px;color:red;'>Valor Total: R$ " . number_format($total, 2) . "</h3>";
                        ?>
                    </div>

                    <form action="finalizar.php" method="post" class="formulario">
                        <div class="group">
                            <label>Tipo de Desconto</label>
                            <select name="Tipodesconto">
                                <option value="%">%</option>
                                <option value="R$">R$</option>
                            </select>
                        </div>
                        <div class="group">
                            <label>Valor do Desconto </label>
                            <input type="text" name="desconto" value="0">
                        </div>
                        <div class="group"></div>
                        <div class="group">
                            <label>Forma de Pagamento</label>
                            <select name="formaPagamento">
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                <option value="Cartão de Débito">Cartão de Débito</option>
                                <option value="PIX">PIX</option>
                                <option value="Vale Alimentação">Vale Alimentação</option>
                                <option value="Crediário">Crediário</option>
                            </select>
                        </div>
                        <div class="group">
                            <label>Cliente</label>
                            <select name="cliente">
                                <option value="1">Consumidor não identificado</option>
                                <?php
                                while ($Cliente = mysqli_fetch_assoc($consultaClientes)) {
                                    echo "<option value='" . $Cliente['id_cliente'] . "'>" . $Cliente['nome'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <label>Parcelas</label>
                        <input type="number" name="parcelas" value="1" style="width: 99.5%;">

                        <i onclick='receber()' style="font-size: 20px;cursor:pointer">↩️</i>
                        <button class="btnEditar">✅ Confirmar</button>

                    </form>
                </div>
            </div>
        </div>

        <script>
            function adicionar(id_produto) {
                window.location.href = "adcionar.php?id_produto=" + id_produto;
            }

            function excluirItem(id_produto) {
                window.location.href = "excluir.php?id_produto=" + id_produto;
            }

            function limparCarrinho() {
                window.location.href = "limpar.php";
            }

            function receber() {
                const modalcarrinho = document.querySelector('.sombracarrinho');
                if (modalcarrinho.style.display === 'block') {
                    modalcarrinho.style.display = 'none';
                    return;
                }
                modalcarrinho.style.display = 'block';
            }

            function diminuir(chave) {
                window.location.href = "diminuir.php?chave=" + chave;
            }

            function aumentar(chave) {
                window.location.href = "aumentar.php?chave=" + chave;
            }
        </script>
    </main>

</body>

</html>