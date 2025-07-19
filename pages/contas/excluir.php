<?php

session_start();
include_once("../../db/conexao.php");

$idConta = $_GET['id'];

$delete = mysqli_query($conexao, "DELETE FROM contas WHERE id_conta = $idConta");

if($delete){
    $_SESSION['mensagem'] = "Conta Exclída com sucesso!";
    header("Location: index.php");
    exit;
}

?>