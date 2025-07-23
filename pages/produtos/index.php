<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if(isset($_POST['pesquisar'])){
    $nome = $_POST['descricao'];
    $consultaproduto = mysqli_query($conexao, "SELECT
                                                    produto.*,
                                                    categoria.descricao AS descricao_categoria,
                                                    fornecedor.nome AS nome_fornecedor
                                                FROM
                                                    produto
                                                INNER JOIN categoria ON categoria.id_categoria = produto.categoria_id
                                                INNER JOIN fornecedor ON fornecedor.id_fornecedor = produto.fornecedor_id
                                                WHERE
                                                    produto.nome LIKE '%$nome%'
                                                ORDER BY produto.nome ASC");
}else{
     $consultaproduto = mysqli_query($conexao,"SELECT 
                                                    produto.*,
                                                    categoria.descricao AS descricao_categoria,
                                                    fornecedor.nome AS nome_fornecedor
                                                FROM
                                                    produto
                                                INNER JOIN categoria ON categoria.id_categoria = produto.categoria_id
                                                INNER JOIN fornecedor ON fornecedor.id_fornecedor = produto.fornecedor_id
                                                ORDER BY produto.nome ASC");
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produtos</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once("../../components/header.php") ?>
    <?php include_once("../../components/menu.php") ?>
    <main>
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
            unset($_SESSION['mensagem']);
        }
        ?>
        <h2><i class="fa-solid fa-cart-plus"></i> produtos</h2>
        <p>Bem-vindo ao painel de produtos. Aqui você pode gerenciar produtos.</p>
        <button class="btnAdicionar" onclick="window.location.href='adicionar.php'"> + Adcionar produto</button>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/excel.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>

        <h3><i class="fa-solid fa-cart-plus"></i> produtos</h3>
        <form action="" method="post" class="formulario" style="width: 100%;">
            <label>Pesquisar Descrição</label>
            <input type="text" name="descricao" placeholder="Pesquise a Descrição aqui...">

            <button class="btnPesquisar" name="pesquisar">Pesquisar</button>
        </form>

        <?php
        if ($consultaproduto->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Nome</th><th>Categoria</th><th>P. Custo</th><th>P . Venda</th><th>Estoque Total</th><th>Estoque Mínimo</th><th>Fornecedor</th><th>Ações</th></tr>";
            while ($produto = mysqli_fetch_assoc($consultaproduto)) {
                echo "<tr>";
                echo "<td>" . $produto['nome'] . "</td>";
                echo "<td>" . $produto['descricao_categoria'] . "</td>";
                echo "<td>" . $produto['preco_custo'] . "</td>";
                echo "<td>" . $produto['preco_venda'] . "</td>";
                echo "<td>" . $produto['estoque_total'] . "</td>";
                echo "<td>" . $produto['estoque_minimo'] . "</td>";
                echo "<td>" . $produto['nome_fornecedor'] . "</td>";
                echo "<td>";
                echo "<a href='editar.php?id=" . $produto['id_produto'] . "' title='Editar' style='margin-right:10px; color: #2980b9;'><i class='fa-solid fa-pencil'></i></a>";
                echo "<a href='excluir.php?id=" . $produto['id_produto'] . "' title='Excluir' style='margin-right:10px; color: #c0392b;'><i class='fa-solid fa-trash'></i></a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Não há produtoes Cadastrados";
        }
        ?>

    </main>

</body>

</html>