<?php

session_start();
include_once("../../db/conexao.php");

$id = $_GET['id'];

$injecao = mysqli_query($conexao,"DELETE FROM anotacoes WHERE id_anotacoes = $id");

if($injecao){
    $_SESSION['mensagem'] = "Anotação Excluída com Sucesso!";
    header("Location: index.php");
    exit;
}


?>