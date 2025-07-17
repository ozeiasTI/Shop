<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if(isset($_POST['btnSalvar'])){
    $descricao_conta = $_POST['descricao'];
    $valor = $_POST['valor'];
    $tipo = $_POST['tipo'];
    $status_conta = "Aberta";
    $data_acerto = $_POST['data'];
    $forma_acerto = $_POST['forma_acerto'];
    $parcelas = $_POST['parcelas'];

    if($parcelas > 1){
        for($i = 0; $i < $parcelas; $i++){
            $conexao = mysqli_query($conexao,"INSERT INTO()VALUES()");
        }
    }else{
        $conexao = mysqli_query($conexao,"INSERT INTO()VALUES()");
    }
    
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuário</title>
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
        <h2><i class="fa-solid fa-money-bill-1"></i> Adicionar Conta</h2>
        <p>Preencha o formulário abaixo para adicionar uma nova conta.</p>
        <h3><i class="fa-solid fa-feather"></i> Adicionar Conta</h3>

        <form action="" method="post" class="formulario">
            <div class="group">
                <label>Descrição:</label>
                <input type="text" name="descricao" required placeholder="Digite uma descrição">
            </div>
            <div class="group">
                <label>Valor:</label>
                <input type="number" name="valor" required placeholder="Digite o valor">
            </div>
            <div class="group">
                <label>Tipo:</label>
                <select name="tipo">
                    <option value="Entrada">Entrada</option>
                    <option value="Saída">Saída</option>
                </select>
            </div>
            <div class="group">
                <label>Data Pagamento:</label>
                <input type="date" name="data">
            </div>
            <div class="group">
                <label>Forma de Acerto</label>
                <select name="forma_acerto">
                    <option value="PIX">PIX</option>
                    <option value="DINHEIRO">DINHEIRO</option>
                    <option value="DÉBITO">DÉBITO</option>
                    <option value="CRÉDITO">CRÉDITO</option>
                    <option value="BOLETO">BOLETO</option>
                </select>
            </div>
            <div class="group">
                <label>Parcelas:</label>
                <input type="number" name="parcelas" min="1" value="1">
            </div>

            <button type="submit" class="btnSalvar"><i class="fas fa-plus"></i> Adicionar Conta</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>
</body>

</html>