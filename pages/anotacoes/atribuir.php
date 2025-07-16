<?php

session_start();
include_once("../../db/conexao.php");

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$id = $_GET['id'];

$consultaAnotacao = mysqli_query($conexao, "SELECT * FROM anotacoes WHERE id_anotacoes = $id");
$Anotacao = mysqli_fetch_assoc($consultaAnotacao);

$usuario_id = $Anotacao['usuario_id'];
$titulo = $Anotacao['titulo'];
$mensagem = $Anotacao['mensagem'];
$data_execucao = $Anotacao['data_execucao'];

$consultaUsuarios = mysqli_query($conexao, "SELECT * FROM usuarios ORDER BY setor,nome ASC");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload do PHPMailer
require_once("../../vendor/autoload.php");

// Definir cabeçalhos para UTF-8
header('Content-Type: text/html; charset=UTF-8');

if (isset($_POST['salvar'])) {
    $usuario_id = $_POST['usuario'];
    $consultaEmail = mysqli_query($conexao, "SELECT * FROM usuarios WHERE id = $usuario_id");
    $email = mysqli_fetch_assoc($consultaEmail);
    $destinatario = $email['email'];

    $injecao = mysqli_query($conexao, "INSERT INTO notificacoes(titulo,usuario_id,mensagem,data_conclusao) VALUES('$titulo', $usuario_id,'$mensagem','$data_execucao')");

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP (exemplo: Gmail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_SESSION['empresa']['email'];
        $mail->Password   = $_SESSION['empresa']['senhaapp'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Configurar charset para UTF-8
        $mail->CharSet = 'UTF-8';

        // Remetente
        $mail->setFrom($_SESSION['empresa']['email'], $_SESSION['empresa']['nome']);

        $mail->addAddress($destinatario);

        // Assunto e mensagem
        $mail->isHTML(true);
        $mail->Subject = 'Tarefa Atribuída';
        $mail->Body = "
    <div style='font-family: Arial, sans-serif; color: #333; background-color: #f4f6f8; padding: 20px; border-radius: 8px;'>
        <h2 style='color: #2c3e50;'>📌 Tarefa Recebida!</h2>
        <p style='font-size: 16px;'>Prezado usuário,</p>
        <p style='font-size: 16px;'>Você recebeu uma nova tarefa. Para mais detalhes e acompanhamento, acesse o sistema de gestão.</p>

        <div style='margin: 20px 0; padding: 15px; background-color: #dff0d8; color: #3c763d; font-size: 18px; font-weight: bold; text-align: center; border-radius: 6px;'>
            Acesse o sistema agora mesmo!
        </div>

        <p style='font-size: 15px;'>Contamos com sua atenção e responsabilidade para realizar a tarefa no prazo estipulado.</p>
        <br>
        <p style='font-size: 14px; color: #666;'>Atenciosamente,</p>
        <p style='font-size: 16px; color: #333; font-weight: bold;'>{$_SESSION['empresa']['nome']}</p>
        <p style='font-size: 14px; color: #999;'>{$_SESSION['empresa']['email']} | {$_SESSION['empresa']['telefone']}</p>
    </div>
";

        $mail->AltBody = "Prezado Usuário, você recebeu uma tarefa, acesse o Sistema para conferir!";

        $mail->send();
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao enviar: {$mail->ErrorInfo}";
    }

    $delete = mysqli_query($conexao, "DELETE FROM anotacoes WHERE id_anotacoes = $id");

    if ($injecao and $delete) {
        $_SESSION['mensagem'] = "Anotação transferida para Usuário!";
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
    <title>Atribuir Anotação</title>
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
        <h2><i class='fa-solid fa-user-shield'></i> Atribuir Anotação</h2>
        <p>Preencha o formulário abaixo para atribuir uma nova Anotação.</p>
        <h3><i class='fa-solid fa-user-shield'></i> Atribuir Anoatção</h3>

        <form action="" method="post" class="formulario">
            <div class="group" style="width: 100%;">
                <label>Usuário:</label>
                <select name="usuario">
                    <?php
                    while ($usuarios = mysqli_fetch_assoc($consultaUsuarios)) {
                        echo "<option value='" . $usuarios['id'] . "'>" . $usuarios['setor'] . " - " . $usuarios['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btnSalvar" name="salvar"><i class='fa-solid fa-user-shield'></i> Atribuir Anotação</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>
</body>

</html>