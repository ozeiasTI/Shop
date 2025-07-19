<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$idConta = $_GET['id'];
$consultaConta = mysqli_query($conexao, "SELECT * FROM contas WHERE id_conta = $idConta");
$LinhaConta = mysqli_fetch_assoc($consultaConta);

if (isset($_POST['salvar'])) {
    // Dados do formulário
    $descricao_conta = $_POST['descricao'];
    $valor = floatval($_POST['valor']);
    $data_acerto = $_POST['data'];
    $forma_acerto = $_POST['forma_acerto'];

    mysqli_query($conexao, "UPDATE contas set descricao_conta = '$descricao_conta', valor = $valor, data_acerto = '$data_acerto', forma_acerto = '$forma_acerto' WHERE id_conta = $idConta");
    
    $_SESSION['mensagem'] = "Conta Editada com sucesso!";
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Conta</title>
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
        <h2><i class="fa-solid fa-pen"></i> Editar Conta</h2>
        <p>Preencha o formulário abaixo para editar uma conta.</p>
        <h3><i class="fa-solid fa-feather"></i> Editar Conta</h3>

        <form action="" method="post" class="formulario">
            <div class="group">
                <label>Descrição:</label>
                <input type="text" name="descricao" required value="<?php echo $LinhaConta['descricao_conta'] ?>">
            </div>
            <div class="group">
                <label>Valor:</label>
                <input type="text" name="valor" required value="<?php echo $LinhaConta['valor'] ?>">
            </div>
            <div class="group">
                <label>Data Pagamento:</label>
                <input type="date" name="data" value="<?php echo $LinhaConta['data_acerto'] ?>">
            </div>
            <div class="group">
                <label>Forma de Acerto</label>
                <select name="forma_acerto">
                    <option value="PIX" <?php echo ($LinhaConta['forma_acerto'] === 'PIX') ? 'selected' : ''; ?>>PIX</option>
                    <option value="DINHEIRO" <?php echo ($LinhaConta['forma_acerto'] === 'DINHEIRO') ? 'selected' : ''; ?>>DINHEIRO</option>
                    <option value="DÉBITO" <?php echo ($LinhaConta['forma_acerto'] === 'DÉBITO') ? 'selected' : ''; ?>>DÉBITO</option>
                    <option value="CRÉDITO" <?php echo ($LinhaConta['forma_acerto'] === 'CRÉDITO') ? 'selected' : ''; ?>>CRÉDITO</option>
                    <option value="BOLETO" <?php echo ($LinhaConta['forma_acerto'] === 'BOLETO') ? 'selected' : ''; ?>>BOLETO</option>
                </select>
            </div>

            <button type="submit" class="btnSalvar" name="salvar"><i class="fa-solid fa-pen"></i> Editar Conta</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>
</body>

</html>