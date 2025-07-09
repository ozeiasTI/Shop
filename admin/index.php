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
</head>

<body>
    <?php include_once("../components/header.php") ?>
    <?php include_once("../components/menu.php") ?>
    <main>
        <?php
            if(isset($_SESSION['mensagem'])){
                echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
                unset($_SESSION['mensagem']);
            }
        ?>
        <h2><i class="fas fa-user-shield"></i> Administrador</h2>
        <p>Esta é a página de administrador. Aqui você pode gerenciar todo o sistema.</p>
        
    </main>
</body>

</html>