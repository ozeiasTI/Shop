<?php

session_start();
require_once("../../db/conexao.php");

$idConta = $_GET['id'];

$consultaConta = mysqli_query($conexao, "SELECT * FROM contas WHERE id_conta = $idConta");
$linha = mysqli_fetch_assoc($consultaConta);

$descricao_conta = $linha['descricao_conta'];
$valor = $linha['valor'];
$tipo = $linha['tipo'];
$data_lancamento = $linha['data_lancamento'];
$data_acerto = $linha['data_acerto'];
$forma_acerto = $linha['forma_acerto'];

$update = mysqli_query($conexao, "UPDATE contas SET status_conta = 'Pago' WHERE id_conta = $idConta");
$injecao = mysqli_query($conexao, "INSERT INTO caixa(valor,tipo,descricao,referencia)VALUES($valor,'$tipo','$descricao_conta','Vendas')");

$_SESSION['mensagem'] = "Acerto Registrado com Sucesso!";
header("Location: index.php");
exit;
