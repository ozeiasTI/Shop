<?php

require_once("db/conexao.php");
session_start();

if (isset($_POST['entrar'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if (!empty($email) && !empty($senha)) {
        $prepara = mysqli_prepare($conexao, "SELECT * FROM usuarios WHERE email = ?");
        mysqli_stmt_bind_param($prepara, "s", $email);
        mysqli_stmt_execute($prepara);
        $resultado = mysqli_stmt_get_result($prepara);

        if ($usuario = mysqli_fetch_assoc($resultado)) {
            if ($senha === $usuario['senha']) {

                $_SESSION['login'] = [
                    "id" => $usuario['id'],
                    "nome" => $usuario['nome'],
                    "cpf" => $usuario['cpf'],
                    "data_cadastro" => $usuario['data_cadastro'],
                    "data_nascimento" => $usuario['data_nascimento'],
                    "foto" => $usuario['foto'],
                    "ativo" => $usuario['ativo'],
                    "email" => $usuario['email'],
                    "senha" => $usuario['senha'],
                    "funcao" => $usuario['funcao'],
                    "telefone" => $usuario['telefone'],
                    "endereco" => $usuario['endereco'],                 
                ];

                if($_SESSION['login']['ativo'] == 'NÃO'){
                    $_SESSION['mensagem-login'] = 'Você foi desativado, procure o Administrador!';
                    header("Location: index.php");
                    exit;
                }

                $consulta_empresa = mysqli_query($conexao, "SELECT * FROM empresa");
                $dados_empresa = mysqli_fetch_assoc($consulta_empresa);
                $_SESSION['empresa'] = [
                    "nome" => $dados_empresa['nome'],
                    "endereco" => $dados_empresa['endereco'],
                    "telefone" => $dados_empresa['telefone'],
                    "email" => $dados_empresa['email'],
                    "senhaapp" => $dados_empresa['senhaapp'],
                    "cnpj" => $dados_empresa['cnpj'],
                    "logo" => $dados_empresa['logo']
                ];

                if ($_SESSION['login']['funcao'] === 'Administrador') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: pages/inicio.php");
                }
                exit;
            } else {
                $_SESSION['mensagem-login'] = 'Senha Incorreta.';
            }
        } else {
            $_SESSION['mensagem-login'] = 'Usuario não encontrado.';
        }

        mysqli_stmt_close($prepara);
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/login.svg" type="image/x-icon">
</head>

<body>
    <div class="login">
        <div class="esquerda">
            <img src="img/login.svg">
            <h1>Bem vindo de volta</h1>
            <p>Para continuar conectado conosco, faça login com suas informações pessoais.</p>
        </div>
        <div class="direita">

            <form action="" method="post">
                <div>
                    <?php
                    if (!empty($_SESSION['mensagem-login'])) {
                        echo "<h4>" . $_SESSION['mensagem-login'] . "</h4>";
                        unset($_SESSION['mensagem-login']);
                    }
                    ?>
                </div>
                <div class="bloco">
                    <label><i class="fa-solid fa-circle-user"></i> E-mail:</label>
                    <input type="email" name="email" placeholder="Digite o e-mail..." required>
                </div>
                <div class="bloco">
                    <label><i class="fa-solid fa-unlock-keyhole"></i> Senha:</label>
                    <input type="password" name="senha" placeholder="Digite a senha..." required>
                </div>

                <input type="submit" value="ENTRAR" name="entrar">
            </form>
        </div>
    </div>
</body>

</html>