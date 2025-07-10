<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM usuarios WHERE id = $id";
$result = $conexao->query($sql);

if (isset($_POST['btnEditarUsuario'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $funcao = $_POST['funcao'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $ativo = $_POST['ativo'];

    $sqlUpdate = "UPDATE usuarios SET 
                        nome = '$nome', 
                        email = '$email', 
                        senha = '$senha', 
                        funcao = '$funcao', 
                        cpf = '$cpf', 
                        endereco = '$endereco', 
                        telefone = '$telefone', 
                        ativo = '$ativo' 
                      WHERE id = $id";

    if ($conexao->query($sqlUpdate) === TRUE) {
        $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
        header("Location: usuarios.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar usuário: " . $conexao->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
        <h2><i class="fas fa-user-edit"></i> Editar Usuário</h2>
        <p>Altere o formulário abaixo para editar o usuário.</p>
        <form action="" method="post">
            <div class="formulario">
                <?php
                if ($result->num_rows > 0) {
                    $usuario = $result->fetch_assoc();
                ?>
                    <div class="group">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                    </div>
                    <div class="group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <div class="group">
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" value="<?php echo htmlspecialchars($usuario['senha']); ?>">
                    </div>
                    <div class="group">
                        <label for="funcao">Função:</label>
                        <select name="funcao" id="funcao">
                            <option value="Administrador" <?php echo ($usuario['funcao'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                            <option value="Gerente" <?php echo ($usuario['funcao'] === 'Gerente') ? 'selected' : ''; ?>>Gerente</option>
                            <option value="Vendedor" <?php echo ($usuario['funcao'] === 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                            <option value="Usuário" <?php echo ($usuario['funcao'] === 'Usuário') ? 'selected' : ''; ?>>Usuário</option>
                            <option value="Cliente" <?php echo ($usuario['funcao'] === 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
                            <option value="Fornecedor" <?php echo ($usuario['funcao'] === 'Fornecedor') ? 'selected' : ''; ?>>Fornecedor</option>
                            <option value="Entregador" <?php echo ($usuario['funcao'] === 'Entregador') ? 'selected' : ''; ?>>Entregador</option>
                            <option value="Financeiro" <?php echo ($usuario['funcao'] === 'Financeiro') ? 'selected' : ''; ?>>Financeiro</option>
                            <option value="Suporte" <?php echo ($usuario['funcao'] === 'Suporte') ? 'selected' : ''; ?>>Suporte</option>
                            <option value="Marketing" <?php echo ($usuario['funcao'] === 'Marketing') ? 'selected' : ''; ?>>Marketing</option>
                            <option value="Desenvolvedor" <?php echo ($usuario['funcao'] === 'Desenvolvedor') ? 'selected' : ''; ?>>Desenvolvedor</option>
                            <option value="Analista" <?php echo ($usuario['funcao'] === 'Analista') ? 'selected' : ''; ?>>Analista</option>
                            <option value="Outros" <?php echo ($usuario['funcao'] === 'Outros') ? 'selected' : ''; ?>>Outros</option>

                        </select>
                    </div>
                    <div class="group">
                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required>
                    </div>
                    <div class="group">
                        <label for="endereco">Endereço:</label>
                        <input type="text" name="endereco" id="endereco" value="<?php echo htmlspecialchars($usuario['endereco']); ?>" required>
                    </div>
                    <div class="group">
                        <label for="telefone">Telefone:</label>
                        <input type="text" name="telefone" id="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>" required>
                    </div>
                    <div class="group">
                        <label for="ativo">Ativo:</label>
                        <select name="ativo" id="ativo">
                            <option value="SIM" <?php echo ($usuario['ativo'] === 'SIM') ? 'selected' : ''; ?>>SIM</option>
                            <option value="NÃO" <?php echo ($usuario['ativo'] === 'NÃO') ? 'selected' : ''; ?>>NÃO</option>
                        </select>
                    </div>
                    <button type="submit" name="btnEditarUsuario" class="btnSalvar"><i class="fas fa-save"></i> Salvar</button>
                    <button type="button" class="btnCancelar" onclick="window.location.href='usuarios.php'"><i class="fas fa-times"></i> Cancelar</button>
                <?php
                } else {
                    echo "<p>Usuário não encontrado.</p>";
                }
                ?>
            </div>
        </form>
    </main>
</body>

</html>