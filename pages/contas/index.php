<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}
$meuID = $_SESSION['login']['id'];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas</title>
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
        <h2><i class="fa-solid fa-sack-dollar"></i> Contas</h2>
        <p>Bem-vindo ao painel de Contas. Aqui você pode gerenciar todas as suas contas.</p>
        <button class="btnAdicionar" onclick="window.location.href='adicionar.php'"> + Adcionar Conta</button>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/planilha.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>
        <h3><i class="fa-solid fa-sack-dollar"></i> Minhas Contas</h3>

    </main>
</body>

</html>