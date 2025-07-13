<?php

require_once("../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        .main-esquerda {
            width: 80%;
            border: 1px solid red;
            height: 100vh;
            float: left;
        }

        .main-direita {
            width: 20%;
            border: 1px solid blue;
            height: 100vh;
            float: left;text-align: center;
        }
    </style>
</head>

<body>
    <?php include_once("../components/header.php") ?>
    <?php include_once("../components/menu.php") ?>
    <main>
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
            unset($_SESSION['mensagem']);
        }
        ?>
        <h2><i class="fas fa-user-shield"></i> Administrador</h2>
        <p>Esta é a página de administrador. Aqui você pode gerenciar todo a empresa.</p>
        <div>
            <button class="btnAdicionar" onclick="window.location.href='empresa/editarEmpresa.php'"><i class="fa-solid fa-wand-magic-sparkles"></i> Editar Empresa</button>
        </div>

        <div class="main-esquerda">

        </div>
        <div class="main-direita">
            <h2>Painel de Notificações</h2>
            
        </div>
    </main>
</body>

</html>