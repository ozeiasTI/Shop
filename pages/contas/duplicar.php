<?php

session_start();
require_once("../../db/conexao.php");

$idConta = $_GET['id'];

$consultaConta = mysqli_query($conexao,"SELECT * FROM contas WHERE id_conta = $idConta");
$linha = mysqli_fetch_assoc($consultaConta);

$descricao_conta = $linha['descricao_conta'];
$valor = $linha['valor'];
$tipo = $linha['tipo'];
$status_conta = $linha['status_conta'];
$data_acerto = $linha['data_acerto'];
$forma_acerto = $linha['forma_acerto'];

$injecao = mysqli_query($conexao,"INSERT INTO contas(descricao_conta,valor,tipo,status_conta,data_acerto,forma_acerto)VALUES('$descricao_conta',$valor,'$tipo','$status_conta','$data_acerto','$forma_acerto')");

if($injecao){
    $_SESSION['mensagem'] = "Conta Duplicada com sucesso!";
    header("Location: index.php");
    exit;
}


?>