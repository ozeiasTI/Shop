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
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            flex: 1;
            text-align: center;
             box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
        .card h3 {
            margin-bottom: 10px;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
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
            <div class="card">
                <h3>Total de Usuários</h3>
                <?php
                    $consultaUsuarios = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM usuarios");
                    $resultado = mysqli_fetch_assoc($consultaUsuarios);
                    echo "<p>" . $resultado['total'] . "</p>";
                ?>
            </div>
        </div>
    </main>

</body>
</html>