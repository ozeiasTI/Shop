<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if(isset($_POST['pesquisar'])){
    $descricao = $_POST['descricao'];
    $consultaCategoria = mysqli_query($conexao, "SELECT * FROM categoria WHERE descricao LIKE '%$descricao%' ORDER BY descricao ASC");
}else{
     $consultaCategoria = mysqli_query($conexao, "SELECT * FROM categoria ORDER BY descricao ASC");
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
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
        <h2><i class="fa-solid fa-table-list"></i> Categorias</h2>
        <p>Bem-vindo ao painel de Categorias. Aqui você pode gerenciar categorias.</p>
        <button class="btnAdicionar" onclick="window.location.href='adicionar.php'"> + Adcionar Categoria</button>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/excel.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>

        <h3><i class="fa-solid fa-feather"></i></i> Categorias</h3>
        <form action="" method="post" class="formulario" style="width: 100%;">
            <label>Pesquisar Descrição</label>
            <input type="text" name="descricao" placeholder="Pesquise a Descrição aqui...">

            <button class="btnPesquisar" name="pesquisar">Pesquisar</button>
        </form>

        <?php
        if ($consultaCategoria->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Descrição</th><th colspan=2>Ações</th></tr>";
            while ($categoria = mysqli_fetch_assoc($consultaCategoria)) {
                echo "<tr>";
                echo "<td>" . $categoria['descricao'] . "</td>";
                echo "<td>";
                echo "<a href='editar.php?id=" . $categoria['id_categoria'] . "' title='Editar' style='margin-right:10px; color: #2980b9;'><i class='fa-solid fa-pencil'></i></a>";
                 echo "</td>";
                 echo "<td>";
                echo "<a href='excluir.php?id=" . $categoria['id_categoria'] . "' title='Excluir' style='margin-right:10px; color: #c0392b;'><i class='fa-solid fa-trash'></i></a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Não há categoriaes Cadastrados";
        }
        ?>

    </main>

</body>

</html>