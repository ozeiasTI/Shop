<?php

require_once("../../../db/conexao.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("../../../vendor/autoload.php");

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$meuID = $_SESSION['login']['id'];
$consultaUsuarios = mysqli_query($conexao, "SELECT * FROM usuarios WHERE ativo != 'NÃO' AND id != $meuID ORDER BY nome,setor ASC");

if (isset($_POST['Cadastrar'])) {
    $usuario_id = $_POST['usuario'];

    $pegar_email = mysqli_query($conexao, "SELECT * FROM usuarios WHERE id = $usuario_id");
    $dados_email = mysqli_fetch_assoc($pegar_email);
    $email = $dados_email['email'];

    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];
    $data_conclusao = $_POST['data_conclusao'];


    $injecao = mysqli_query($conexao, "INSERT INTO notificacoes(titulo,usuario_id,mensagem,data_conclusao) VALUES('$titulo', $usuario_id,'$mensagem','$data_conclusao')");

    if (!empty($email)) {

        $mail = new PHPMailer(true);

        try {
            // Configurações SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_SESSION['empresa']['email'];
            $mail->Password   = $_SESSION['empresa']['senhaapp'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // Remetente e destinatário
            $mail->setFrom($_SESSION['empresa']['email'], $_SESSION['empresa']['nome']);
            $mail->addAddress($email, $dados_email['nome']);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = '🛡️ Notificação Cadastrada';

            // Corpo HTML com estilos
            $mail->Body = "
                    <div style='font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; border-radius: 8px;'>
                        <h2 style='color: #005baa;'>Olá, {$dados_email['nome']}!</h2>
                        <p>Uma notificação foi cadastrada para você.</p>
                        <p>Acesse o sistema para atualizar o andamento da notificação, antes do prazo final!</p>
                        <div style='margin: 20px 0; padding: 15px; background-color: #e3f2fd; color: #0d47a1; font-size: 24px; font-weight: bold; text-align: center; border-radius: 6px;'>
                            {$data_conclusao}
                        </div>
                        <p>Por favor não deixe de cumprir com prazos.</p>
                        <br>
                        <p style='font-size: 14px; color: #666;'>Atenciosamente,</p>
                        <p style='font-size: 16px; color: #333; font-weight: bold;'>{$_SESSION['empresa']['nome']}</p>
                        <p style='font-size: 14px; color: #999;'>{$_SESSION['empresa']['email']} | {$_SESSION['empresa']['telefone']}</p>
                    </div>
                ";

            $mail->send();
            $_SESSION['mensagem'] = 'Notificação Cadastrada com sucesso!';
            header('Location: ../usuarios.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['mensagem-login'] = "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once("../../../components/header.php") ?>
    <?php include_once("../../../components/menu.php") ?>
    <main>
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
            unset($_SESSION['mensagem']);
        }
        ?>
        <h2><i class="fa-solid fa-bell"></i> Notificação</h2>
        <p>Bem-vindo ao painel de notificações. Aqui você pode mandar e gerenciar notificações.</p>

        <h3><i class="fa-solid fa-feather"></i> Cadastro de Notificação</h3>
        <form action="" method="post" class="formulario">

            <label>Título</label>
            <input type="text" name="titulo" placeholder="Digite um Título...">

            <label>Usuário</label>
            <select name="usuario">
                <option value="">Selecione um usuario</option>
                <?php
                while ($dadosUsuarios = mysqli_fetch_assoc($consultaUsuarios)) {
                    echo "<option value='" . $dadosUsuarios['id'] . "'>" .$dadosUsuarios['setor']. " - " .$dadosUsuarios['nome'] . "</option>";
                }
                ?>
            </select>

            <label>Data de Conclusão</label>
            <input type="date" name="data_conclusao">

            <label>Mensagem</label>
            <textarea name="mensagem" rows="4"></textarea>

            <button type="submit" class="btnSalvar" name="Cadastrar">Cadastrar</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='../usuarios.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>

</body>

</html>