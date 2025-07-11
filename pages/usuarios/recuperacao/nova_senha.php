<?php
session_start();
require_once("../../../db/conexao.php");

$email = $_SESSION['email_recuperacao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoInformado = $_POST['codigo'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($senha === $confirmar) {
        // Busca o usuário pelo e-mail e código
        $prepara = mysqli_prepare($conexao, "SELECT * FROM usuarios WHERE email = ? AND codigo_recuperacao = ?");
        mysqli_stmt_bind_param($prepara, "ss", $email, $codigoInformado);
        mysqli_stmt_execute($prepara);
        $resultado = mysqli_stmt_get_result($prepara);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $senhaHash = $senha;

            // Atualiza a senha e limpa o código
            $update = mysqli_prepare($conexao, "UPDATE usuarios SET senha = ?, codigo_recuperacao = NULL WHERE email = ?");
            mysqli_stmt_bind_param($update, "ss", $senhaHash, $email);
            mysqli_stmt_execute($update);

            $_SESSION['mensagem-login'] = "Senha atualizada com sucesso!";
            header("Location: ../../../index.php");
            exit;
        } else {
            $erro = "Código incorreto.";
        }

        mysqli_stmt_close($prepara);
    } else {
        $erro = "As senhas não coincidem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Senha</title>
    <link rel="stylesheet" href="../../../css/login.css">
     <link rel="shortcut icon" href="../../../img/login.svg" type="image/x-icon">
    <style>
        a,
        p {
            color: white;
        }
    </style>
</head>
<body>
    <div class="login">
        <div class="direita" style="width: 100%; border-radius: 10px;">
            <form method="post" style="padding: 10px;">
                <h3>Digite o código e a nova senha</h3><br>
                <?php if (!empty($erro)) echo "<p style='color:red;background-color:white;padding:2px;text-align:center;'>$erro</p>"; ?>
                <label>Código recebido:</label>
                <input type="text" name="codigo" required value=".">
                <label>Nova Senha:</label>
                <input type="password" name="senha" required placeholder="Digite a senha aqui...">
                <label>Confirmar Nova Senha:</label>
                <input type="password" name="confirmar" required placeholder="Confirme a senha aqui...">
                <input type="submit" value="Atualizar Senha"><br><br>
                <a href="../../../index.php">Voltar</a><br>
            </form>
        </div>
    </div>
</body>
</html>
