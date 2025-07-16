<?php

session_start();
include_once("../../db/conexao.php");

$id = $_GET['id'];

$consultaDados = mysqli_query($conexao, "SELECT * FROM anotacoes WHERE id_anotacoes = $id");
$dados = mysqli_fetch_assoc($consultaDados);

$usuario_id = $dados['usuario_id'];
$titulo = $dados['titulo'];
$mensagem = $dados['mensagem'];
$categoria_anotacoes = $dados['categoria_anotacoes'];
$data_execucao = $dados['data_execucao'];
$status_anotacoes = $dados['status_anotacoes'];

$injecao = mysqli_query($conexao,"INSERT INTO anotacoes(usuario_id,titulo,mensagem,categoria_anotacoes,data_execucao,status_anotacoes) VALUES($usuario_id,'$titulo','$mensagem','$categoria_anotacoes','$data_execucao','$status_anotacoes')");

if($injecao){
    $_SESSION['mensagem'] = "Anotação Duplicada Com sucesso!";
    header("Location: index.php");
    exit;
}


?>