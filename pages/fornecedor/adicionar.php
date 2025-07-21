<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if(isset($_POST['salvar'])){
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $ramo = $_POST['ramo'];

    $injecao = mysqli_query($conexao,"INSERT INTO fornecedor(nome,cnpj,endereco,ramo)VALUES('$nome','$cnpj','$endereco','$ramo')");

    if($injecao){
        $_SESSION['mensagem'] = "Cadastro Efetivado com Sucesso!";
        header("Location: index.php");
        exit;
    }

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adcionar Fornecedor</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include_once("../../components/header.php")?>
    <?php include_once("../../components/menu.php")?>
    <main>
        <?php
            if(isset($_SESSION['mensagem'])){
                echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
                unset($_SESSION['mensagem']);
            }
        ?>
        <h2><i class="fa-solid fa-plus"></i> Adcionar Fornecedor</h2>
        <p>Bem-vindo ao painel de Adcionar Fornecedor. Aqui você pode gerenciar os fornecedores.</p>
        <form action="" method="post" class="formulario">
            <div class="group">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Digite o nome do Fornecedor">
            </div>
            <div class="group">
                <label>CNPJ</label>
                <input type="text" name="cnpj" placeholder="Digite o CNPJ">
            </div>
            <div class="group">
                <label>Endereço</label>
                <input type="text" name="endereco" placeholder="Digite o Endereço do Fornecedor">
            </div>
            <div class="group">
                <label>Ramo</label>
                <input type="text" name="ramo" placeholder="Digite o ramo do Fornecedor">
            </div>
             <button type="submit" class="btnSalvar" name="salvar"><i class="fas fa-plus"></i> Adicionar Fornecedor</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>

</body>
</html>