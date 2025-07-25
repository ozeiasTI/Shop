<?php

require_once("../../db/conexao.php");
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
            <h2 style="color: white;"> Caixa</h2>
            <div>
                <a style="color: white;" href="index.php"><i class="fa-solid fa-cash-register"></i> Venda</a>
                <a style="color: white;background-color:#1e7180cb;" href="caixa.php"><i class="fa-solid fa-dollar-sign"></i> Caixa</a>
            </div>
        </div>
        <?php
            if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])){
                
            }
        ?>
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