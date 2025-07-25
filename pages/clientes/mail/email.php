<?php

require_once("../../../db/conexao.php");

$idcliente = $_GET['id'];
$consultaCliente = mysqli_query($conexao,"SELECT * FROM clientes WHERE id_cliente = '$idcliente'");
$cliente = mysqli_fetch_assoc($consultaCliente);

$email = $cliente['email'];

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload do PHPMailer
require_once("../../../vendor/autoload.php");

// Definir cabeçalhos para UTF-8
header('Content-Type: text/html; charset=UTF-8');

$mensagem_sucesso = '';
$mensagem_erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        // Destinatário(s)
        $destinatario = $email;
        $mail->addAddress($destinatario);

        // Assunto e mensagem
        $mail->isHTML(true);
        $mail->Subject = $_POST['assunto'];
        $mail->Body    = nl2br($_POST['mensagem']);
        $mail->AltBody = strip_tags($_POST['mensagem']);

        // Anexos (se houver)
        if (!empty($_FILES['anexo']['name'])) {
            $mail->addAttachment($_FILES['anexo']['tmp_name'], $_FILES['anexo']['name']);
        }

        $mail->send();
        $_SESSION['mensagem'] = 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao enviar: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar E-mail</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once("../../../components/header.php") ?>
    <?php include_once("../../../components/menu.php") ?>
    <main>
        <h2>Enviar E-mail</h2>
        <p>Você enviará e-mail para <span style="color: red;"><?php echo $email; ?><span></p><br>

        <h3><i class="fa-solid fa-feather"></i> Enviar E-mail</h3>

        <?php
            if (!empty($_SESSION['mensagem'])) {
                echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
                unset($_SESSION['mensagem']);
            }
        ?>

        <form method="post" enctype="multipart/form-data" accept-charset="UTF-8" class="formulario" style="width: 100%;">
            <label>Assunto:</label><br>
            <input type="text" name="assunto" required><br><br>

            <label>Mensagem:</label><br>
            <textarea name="mensagem" rows="6" required></textarea><br><br>

            <label>Anexo (opcional):</label><br>
            <input type="file" name="anexo"><br><br>

            <button type="submit" class="btnSalvar">Enviar</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='../index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>
</body>

</html>