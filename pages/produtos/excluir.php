<?php

session_start();
require_once("../../db/conexao.php");

$idProduto = $_GET['id'];

$delete = mysqli_query($conexao,"DELETE FROM produto WHERE id_produto = '$idProduto'");

if($delete){
    $_SESSION['mensagem'] = "Produto Excluido com Sucesso!";
    header("Location: index.php");
    exit;
}


?>