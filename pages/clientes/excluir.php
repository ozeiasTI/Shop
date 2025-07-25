<?php

session_start();
require_once("../../db/conexao.php");

$idCliente = $_GET['id'];

$delete = mysqli_query($conexao,"DELETE FROM clientes WHERE id_cliente = '$idCliente'");

if($delete){
    $_SESSION['mensagem'] = "Cliente Deletado com Sucesso!";
    header("location: index.php");
    exit;
}

?>