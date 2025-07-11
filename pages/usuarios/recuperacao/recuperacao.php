<?php
session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['recuperar'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!empty($email)) {
        $prepara = mysqli_prepare($conexao, "SELECT * FROM usuarios WHERE email = ?");
        mysqli_stmt_bind_param($prepara, "s", $email);
        mysqli_stmt_execute($prepara);
        $resultado = mysqli_stmt_get_result($prepara);

        if ($resultado && $resultado->num_rows > 0) {
            $usuario = mysqli_fetch_assoc($resultado);

            // Gera código aleatório simples
            $codigo = chr(mt_rand(97, 122)) . rand(100, 999) . chr(mt_rand(97, 122)) . rand(100, 999);
            $update = mysqli_query($conexao, "UPDATE usuarios SET codigo_recuperacao = '$codigo' WHERE email = '$email'");

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
                $mail->addAddress($email, $usuario['nome']);

                // Conteúdo do e-mail
                $mail->isHTML(true);
                $mail->Subject = '🔐 Recuperação de Senha';

                // Corpo HTML com estilos
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; border-radius: 8px;'>
                        <h2 style='color: #005baa;'>Olá, {$usuario['nome']}!</h2>
                        <p>Recebemos uma solicitação para recuperação de senha da sua conta.</p>
                        <p>Utilize o código abaixo para continuar o processo:</p>
                        <div style='margin: 20px 0; padding: 15px; background-color: #e3f2fd; color: #0d47a1; font-size: 24px; font-weight: bold; text-align: center; border-radius: 6px;'>
                            {$codigo}
                        </div>
                        <p>Se você não solicitou esta recuperação, ignore este e-mail.</p>
                        <br>
                        <p style='font-size: 14px; color: #666;'>Atenciosamente,</p>
                        <p style='font-size: 16px; color: #333; font-weight: bold;'>{$_SESSION['empresa']['nome']}</p>
                        <p style='font-size: 14px; color: #999;'>{$_SESSION['empresa']['email']} | {$_SESSION['empresa']['telefone']}</p>
                    </div>
                ";
                // Versão alternativa (texto puro)
                $mail->AltBody = "Olá, {$usuario['nome']}!\n\nSeu código de recuperação de senha é: {$codigo}\n\nSe não solicitou, ignore esta mensagem.\n\nAtenciosamente,\n{$_SESSION['empresa']['nome']}";

                $mail->send();
                $_SESSION['email_recuperacao'] = $email; // para carregar o e-mail na próxima página
                header("Location: nova_senha.php");
                exit;
            } catch (Exception $e) {
                $_SESSION['mensagem-login'] = "Erro ao enviar e-mail: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['mensagem-login'] = "E-mail não localizado.";
        }

        mysqli_stmt_close($prepara);
    } else {
        $_SESSION['mensagem-login'] = "Por favor, insira um e-mail válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="../../../css/login.css">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
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
            <form action="" method="post">
                <div>
                    <?php
                    if (!empty($_SESSION['mensagem-login'])) {
                        echo "<h4>" . htmlspecialchars($_SESSION['mensagem-login']) . "</h4>";
                        unset($_SESSION['mensagem-login']);
                    }
                    ?>
                </div>
                <div class="bloco">
                    <p>Digite o e-mail para recuperação de senha</p><br>
                    <label><i class="fa-solid fa-circle-user"></i> E-mail:</label>
                    <input type="email" name="email" placeholder="Digite o e-mail..." required>
                </div>
                <input type="submit" value="RECUPERAR" name="recuperar"><br><br>
                <a href="../../../index.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>