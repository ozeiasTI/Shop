<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if(isset($_POST['pesquisar'])){
    $nome = $_POST['nome'];
    $consultaFornecedor = mysqli_query($conexao, "SELECT * FROM fornecedor WHERE nome LIKE '%$nome%' ORDER BY nome ASC");
}else{
     $consultaFornecedor = mysqli_query($conexao, "SELECT * FROM fornecedor ORDER BY nome ASC");
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
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
        <h2><i class="fa-solid fa-truck-moving"></i> Fornecedores</h2>
        <p>Bem-vindo ao painel de Fornecedores. Aqui você pode gerenciar os Fornecedores.</p>
        <button class="btnAdicionar" onclick="window.location.href='adicionar.php'"> + Adcionar Fornecedor</button>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/excel.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>

        <h3><i class="fa-solid fa-feather"></i></i> Forneedores</h3>
        <form action="" method="post" class="formulario" style="width: 100%;">
            <label>Pesquisar Nome</label>
            <input type="text" name="nome" placeholder="Pesquise o nome aqui...">

            <button class="btnPesquisar" name="pesquisar">Pesquisar</button>
        </form>

        <?php
        if ($consultaFornecedor->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Nome</th><th>Endereço</th><th>CNPJ</th><th>Ramo</th><th>Email</th><th colspan=3>Ações</th></tr>";
            while ($fornecedor = mysqli_fetch_assoc($consultaFornecedor)) {
                echo "<tr>";
                echo "<td>" . $fornecedor['nome'] . "</td>";
                echo "<td>" . $fornecedor['endereco'] . "</td>";
                echo "<td>" . $fornecedor['cnpj'] . "</td>";
                echo "<td>" . $fornecedor['ramo'] . "</td>";
                echo "<td>" . $fornecedor['email'] . "</td>";
                echo "<td>";
                echo "<a href='editar.php?id=" . $fornecedor['id_fornecedor'] . "' title='Editar' style='margin-right:10px; color: #2980b9;'><i class='fa-solid fa-pencil'></i></a>";
                echo "</td>";
                echo "<td>";
                echo "<a href='excluir.php?id=" . $fornecedor['id_fornecedor'] . "' title='Excluir' style='margin-right:10px; color: #c0392b;'><i class='fa-solid fa-trash'></i></a>";
                echo "</td>";
                echo "<td>";
                echo "<a href='mail/email.php?id=" . $fornecedor['id_fornecedor'] . "' title='Excluir' style='margin-right:10px; color: #962bc0ff;'><i class='fa-solid fa-envelopes-bulk'></i></a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Não há fornecedores Cadastrados";
        }
        ?>

    </main>

</body>

</html>