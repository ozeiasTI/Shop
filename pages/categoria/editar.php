<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$consultaCategoria = mysqli_query($conexao,"SELECT * FROM categoria");
$categorias = mysqli_fetch_assoc($consultaCategoria);

$id_categoria = $_GET['id'];

if(isset($_POST['salvar'])){
    $nome = $_POST['nome'];

    $injecao = mysqli_query($conexao,"UPDATE categoria SET descricao = '$nome' WHERE id_categoria = '$id_categoria'");

    if($injecao){
        $_SESSION['mensagem'] = "Categoria Ediatado com Sucesso!";
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
    <title>Editar categoria</title>
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
        <h2><i class="fa-solid fa-plus"></i> Editar categoria</h2>
        <p>Bem-vindo ao painel de Editar categoria. Aqui você pode gerenciar os categoriaes.</p>
        <form action="" method="post" class="formulario">
            
            <label>Nome</label>
            <input type="text" name="nome" value="<?php echo $categorias['descricao'] ;?>">

            <button type="submit" class="btnSalvar" name="salvar"><i class="fas fa-plus"></i> Editar categoria</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>

</body>
</html>