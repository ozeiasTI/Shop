<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$idCliente = $_GET['id'];
$consultacliente = mysqli_query($conexao,"SELECT * FROM clientes WHERE id_cliente = $idCliente");
$cliente = mysqli_fetch_assoc($consultacliente);

if(isset($_POST['salvar'])){
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $injecao = mysqli_query($conexao,"UPDATE clientes SET nome = '$nome', cpf = '$cpf', endereco = '$endereco', telefone = '$telefone', email = '$email' WHERE id_cliente = $idCliente");

    if($injecao){
        $_SESSION['mensagem'] = "Cadastro Editado com Sucesso!";
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
    <title>Adcionar cliente</title>
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
        <h2><i class="fa-solid fa-plus"></i> Editar cliente</h2>
        <p>Bem-vindo ao painel de editar cliente. Aqui você pode editar os clientees.</p>
        <form action="" method="post" class="formulario">
           
            <label>Nome</label>
            <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>">
           
            <div class="group">
                <label>CPF</label>
                <input type="text" name="cpf" value="<?php echo $cliente['cpf']; ?>">
            </div>
            <div class="group">
                <label>Endereço</label>
                <input type="text" name="endereco" value="<?php echo $cliente['endereco']; ?>">
            </div>
            <div class="group">
                <label>Telefone</label>
                <input type="text" name="telefone" value="<?php echo $cliente['telefone']; ?>">
            </div>
            <div class="group">
                <label>E-mail</label>
                <input type="text" name="email" value="<?php echo $cliente['email']; ?>">
            </div>

            <button type="submit" class="btnSalvar" name="salvar"><i class="fas fa-plus"></i> Editar cliente</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>

</body>
</html>