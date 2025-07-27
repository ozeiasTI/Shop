<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "shop";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);
mysqli_set_charset($conexao, "utf8mb4");

date_default_timezone_set("America/Cuiaba");

//injecao de cliente 0
$consultaCliente = mysqli_query($conexao,"SELECT * FROM clientes WHERE id_cliente = 1");

if(mysqli_num_rows($consultaCliente) == 0){
    $injecao = mysqli_query($conexao,"INSERT INTO clientes(id_cliente,nome)VALUES(1,'Não Identificado')");
}

?>