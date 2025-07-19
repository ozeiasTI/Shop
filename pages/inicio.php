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
    <title>Inicio</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        .dashboard-cards {
            margin-top: 20px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            padding: 20px;
            border-radius: 40px 8px 40px 8px;
            flex: 1;
            text-align: center;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .card h4 {
            margin-bottom: 10px;
            font-size: 20px;
            color: white;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

    </style>
</head>
<body>
    <?php include_once("../components/header.php")?>
    <?php include_once("../components/menu.php")?>
    <main>
        <?php
            if(isset($_SESSION['mensagem'])){
                echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
                unset($_SESSION['mensagem']);
            }
        ?>
        <h2><i class="fas fa-signal"></i> Dashboard</h2>
        <p>Bem-vindo ao painel de controle. Aqui você pode gerenciar o sistema.</p>
        <div class="dashboard-cards">
            <div class="card" style="background-color: #d064d4ff;">
                 <h4>Valor em Caixa(fazendo)</h4>
                <?php
                    $consultacaixa = mysqli_query($conexao, "SELECT SUM(valor) AS total FROM caixa");
                    $resultadocaixa = mysqli_fetch_assoc($consultacaixa);
                    echo "<p>" . $resultadocaixa['total'] . "</p>";
                ?>
            </div>
            <div class="card" style="background-color: #6475d4ff;">
                 <h4>Total de Usuários</h4>
                <?php
                    $consultaUsuarios = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM usuarios");
                    $resultado = mysqli_fetch_assoc($consultaUsuarios);
                    echo "<p>" . $resultado['total'] . "</p>";
                ?>
            </div>
            <div class="card" style="background-color: #be6060ff;">
                 <h4>Total de Contas a Pagar</h4>
                <?php
                    $consultacontaspagar = mysqli_query($conexao, "SELECT SUM(valor) AS total FROM contas WHERE status_conta = 'Aberta' AND tipo = 'Saída'");
                    $resultadocontaspagar = mysqli_fetch_assoc($consultacontaspagar);
                    echo "<p>R$ " . $resultadocontaspagar['total'] . "</p>";
                ?>
            </div>
            <div class="card" style="background-color: #51aa5dff;">
                 <h4>Total de Contas a Receber</h4>
                <?php
                    $consultacontasreceber = mysqli_query($conexao, "SELECT SUM(valor) AS total FROM contas WHERE status_conta = 'Aberta' AND tipo = 'Entrada'");
                    $resultadocontasreceber = mysqli_fetch_assoc($consultacontasreceber);
                    echo "<p>R$ " . $resultadocontasreceber['total'] . "</p>";
                ?>
            </div>
        </div>
    </main>

</body>
</html>