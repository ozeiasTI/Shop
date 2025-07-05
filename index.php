<?php

require_once("db/conexao.php");
session_start();

if(isset($_POST['entrar'])){
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];

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
                <div class="bloco">
                    <label><i class="fa-solid fa-circle-user"></i> E-mail:</label>
                    <input type="email" name="email" placeholder="Digite o e-mail...">
                </div>
                <div class="bloco">
                    <label><i class="fa-solid fa-unlock-keyhole"></i> Senha:</label>
                    <input type="password" name="senha" placeholder="Digite a senha...">
                </div>

                <input type="submit" value="ENTRAR" name="entrar">
            </form>
        </div>
    </div>
</body>

</html>