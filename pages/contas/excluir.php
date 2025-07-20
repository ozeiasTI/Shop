<?php

session_start();
include_once("../../db/conexao.php");

$idConta = $_GET['id'];

$consultaConta = mysqli_query($conexao,"SELECT * FROM contas WHERE id_conta = $idConta");
$linhaConta = mysqli_fetch_assoc($consultaConta);
$status = $linhaConta['status_conta'];

if($status == 'Aberta'){
    $delete = mysqli_query($conexao, "DELETE FROM contas WHERE id_conta = $idConta");
}else{
    $_SESSION['mensagem'] = "Alert [ Não é possivel excluir uma Conta já lançada no Caixa ]!";
    header("Location: index.php");
    exit;
}

if($delete){
    $_SESSION['mensagem'] = "Conta Exclída com sucesso!";
    header("Location: index.php");
    exit;
}

?>