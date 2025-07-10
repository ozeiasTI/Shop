<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "shop";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);
mysqli_set_charset($conexao, "utf8mb4");

date_default_timezone_set("America/Cuiaba");

?>