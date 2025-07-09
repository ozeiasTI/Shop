<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$consultaEmpresa = mysqli_query($conexao, "SELECT * FROM empresa");
$empresa = mysqli_fetch_assoc($consultaEmpresa);

if(isset($_POST['editar'])){
    $id_empresa = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $cnpj = $_POST['cnpj'];

    if(!empty($_FILES['logo']['name'])){
        $logo = $_FILES['logo']['name'];

        $diretorio = $_SERVER['DOCUMENT_ROOT'] .'/Shop/admin/empresa/imagens/';
        $caminhoCompleto = $diretorio . $logo;

        move_uploaded_file($_FILES['logo']['tmp_name'], $caminhoCompleto);

        if(isset($_SESSION['empresa']['logo'])) {
            $fotoAntiga = $_SERVER['DOCUMENT_ROOT'] . '/Shop/admin/empresa/imagens/' . $_SESSION['empresa']['logo'];
            if (is_file($fotoAntiga) && file_exists($fotoAntiga)) {
                unlink($fotoAntiga);
            }
        }

        $sql = "UPDATE empresa SET 
            nome = '$nome', 
            cnpj = '$cnpj', 
            email = '$email', 
            telefone = '$telefone', 
            endereco = '$endereco',
            logo = '$logo'
            WHERE id = $id_empresa";
    } else {
        $sql = "UPDATE empresa SET 
            nome = '$nome', 
            cnpj = '$cnpj', 
            email = '$email', 
            telefone = '$telefone', 
            endereco = '$endereco'
            WHERE id = $id_empresa";
    }

    if ($conexao->query($sql) === TRUE) {
        $_SESSION['empresa']['nome'] = $nome;
        if (!empty($_FILES['logo']['name'])) {
            $_SESSION['empresa']['logo'] = $logo;
        }
        $_SESSION['mensagem'] = "Empresa Editado com sucesso!";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
        
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
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
        <h2><i class="fa-solid fa-wand-magic-sparkles"></i> Editar</h2>
        <p>Esta é a página de edição de dados. Aqui você pode editar os dados da empresa.</p>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="formulario">
                <input type="hidden" name="id" value="<?php echo $empresa['id']; ?>">

                <div class="group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo $empresa['nome']; ?>">
                </div>

                <div class="group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $empresa['email']; ?>">
                </div>

                <div class="group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo $empresa['telefone']; ?>">
                </div>

                <div class="group">
                    <label for="telefone">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" value="<?php echo $empresa['endereco']; ?>">
                </div>

                <div class="group">
                    <label for="telefone">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" value="<?php echo $empresa['cnpj']; ?>">
                </div>
                <div class="group">
                    <label for="telefone">LOGO:</label>
                    <input type="file" name="logo">
                </div>
               
                <button type="submit" name="editar" class="btnAdicionar"><i class="fa-solid fa-wand-magic-sparkles"></i> Salvar</button>
                <button type="button" class="btnCancelar" onclick="window.location.href='../index.php'"><i class="fas fa-times"></i> Cancelar</button>
            </div>
        </form>
    </main>
</body>

</html>