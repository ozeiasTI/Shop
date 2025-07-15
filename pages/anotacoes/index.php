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
    <title>Anotações</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        .quadroAnotacoes {
            width: 100%;
            height: 250px;
            max-width: 350px;
            background-color: #fff;
            border-left: 8px solid #e74c3c;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 16px 20px;
            margin: 15px;
            transition: transform 0.2s ease-in-out;
            display: inline-block;
            vertical-align: top;
        }

        .quadroAnotacoes:hover {
            transform: scale(1.02);
        }

        .quadroAnotacoes h4 {
            margin: 0;
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .quadroAnotacoes span {
            display: block;
            font-size: 0.9rem;
            margin: 6px 0;
            color: #555;
        }

        .quadroAnotacoes p {
            margin-top: 10px;
            font-style: italic;
            font-size: 0.95rem;
            text-align: center;
            color: #7f8c8d;
        }
    </style>
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
        <h2><i class="fa-solid fa-clipboard"></i> Anotações</h2>
        <p>Bem-vindo ao painel de anotações. Aqui você pode gerenciar todas as suas anotações.</p>
        <button class="btnAdicionar" onclick="window.location.href='adicionar.php'"> + Adcionar Anotações</button>

        <h3><i class="fa-solid fa-feather"></i> Minhas Anotações</h3>
        <?php
        $consultaAnotações = mysqli_query($conexao, "SELECT * FROM anotacoes WHERE usuario_id = $meuID");

        while ($linha = mysqli_fetch_assoc($consultaAnotações)) {
            echo "<div class='quadroAnotacoes'>";

            // Botões de ação
            echo "<div class='acoes' style='text-align: right; margin-bottom: 10px;'>";
            echo "<a href='editar.php?id=" . $linha['id_anotacoes'] . "' title='Editar' style='margin-right:10px; color: #2980b9;'><i class='fa-solid fa-pen-to-square'></i></a>";
            echo "<a href='excluir.php?id=" . $linha['id_anotacoes'] . "' title='Excluir' style='color: #c0392b;' onclick='return confirm(\"Tem certeza que deseja excluir esta anotação?\")'><i class='fa-solid fa-trash'></i></a>";
            echo "</div>";

            // Conteúdo da anotação
            echo "<h4><i class='fa-solid fa-note-sticky'></i> " . htmlspecialchars($linha['titulo']) . "</h4>";
            echo "<span><strong>📅 Data:</strong> " . date("d/m/Y", strtotime($linha['data_execucao'])) . "</span>";
            echo "<span><strong>📂 Categoria:</strong> " . htmlspecialchars($linha['categoria_anotacoes']) . "</span>";
            echo "<span><strong>📌 Status:</strong> " . htmlspecialchars($linha['status_anotacoes']) . "</span>";
            echo "<p>“" . nl2br(htmlspecialchars($linha['mensagem'])) . "”</p>";

            echo "</div>";
        }


        ?>

    </main>
</body>

</html>