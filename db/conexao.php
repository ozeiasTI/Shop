<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "shop";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);
mysqli_set_charset($conexao, "utf8mb4");

?>