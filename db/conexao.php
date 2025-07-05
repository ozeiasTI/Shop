<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "shop";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);
mysqli_set_charset($conexao, "utf8mb4");

$consulta_empresa = mysqli_query($conexao, "SELECT * FROM empresa");

if ($consulta_empresa->num_rows > 0) {
    $dados_empresa = mysqli_fetch_assoc($consulta_empresa);

    $_SESSION['empresa'] = [
        "nome" => $dados_empresa['nome'],
    ];
}
?>