<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $funcao = $_POST['funcao'];
    $setor = $_POST['setor'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $ativo = $_POST['ativo'];

    $query = "INSERT INTO usuarios (nome, email, senha, funcao, setor, cpf, data_nascimento, endereco, telefone,ativo) 
              VALUES ('$nome', '$email', '$senha', '$funcao', '$setor' , '$cpf', '$data_nascimento', '$endereco', '$telefone','$ativo')";

    if (mysqli_query($conexao, $query)) {
        $_SESSION['mensagem'] = "Usuário adicionado com sucesso!";
        header("Location: usuarios.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao adicionar usuário: " . mysqli_error($conexao);
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
        <h2><i class="fas fa-user-plus"></i> Adicionar Usuário</h2>
        <p>Preencha o formulário abaixo para adicionar um novo usuário.</p>
        <h3><i class="fa-solid fa-feather"></i> Adicionar Usuário</h3>
        <form action="" method="post" class="formulario">
            <div class="group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required placeholder="Digite o nome do usuário">
            </div>
            <div class="group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Digite o email do usuário">
            </div>
            <div class="group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required placeholder="Digite a senha do usuário">
            </div>
            <div class="group">
                <label for="funcao">Função:</label>
                <select id="funcao" name="funcao">
                    <option value="Administrador">Administrador</option>
                    <option value="Gerente">Gerente</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Atendente">Atendente</option>
                    <option value="Cliente">Cliente</option>
                    <option value="Fornecedor">Fornecedor</option>
                    <option value="Entregador">Entregador</option>
                    <option value="Financeiro">Financeiro</option>
                    <option value="Estoquista">Estoquista</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Projetista">Projetista</option>
                    <option value="Técnico">Técnico</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>
            
            <div class="group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required placeholder="Digite o CPF do usuário">
            </div>
            <div class="group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento">
            </div>
            <div class="group">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Digite o endereço do usuário">
            </div>
            <div class="group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" required placeholder="Digite o telefone do usuário">
            </div>
            <div class="group">
                <label for="setor">Setor:</label>
                <select id="setor" name="setor">
                    <option value="Gerência">Gerência</option>
                    <option value="Administrativo">Administrativo</option>
                    <option value="Vendas">Vendas</option>
                    <option value="Atendimento">Atendimento</option>
                    <option value="Financeiro">Financeiro</option>
                    <option value="Estoque">Estoque</option>
                    <option value="Logística">Logística</option>
                    <option value="Corte e Montagem">Corte e Montagem</option>
                    <option value="Elétrica">Elétrica</option>
                    <option value="Hidráulica">Hidráulica</option>
                    <option value="Acabamentos">Acabamentos</option>
                    <option value="Ferramentas">Ferramentas</option>
                    <option value="TI">TI</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Projetos">Projetos</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>
            <div class="group">
                <label for="Ativo">Ativo</label>
                <select name="ativo">
                    <option value="SIM">SIM</option>
                    <option value="NÃO">NÃO</option>
                </select>
            </div>
            <button type="submit" class="btnSalvar"><i class="fas fa-plus"></i> Adicionar Usuário</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='usuarios.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>
</body>

</html>