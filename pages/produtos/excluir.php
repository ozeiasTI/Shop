<?php

session_start();
require_once("../../db/conexao.php");

$idProduto = $_GET['id'];
$consultaProduto = mysqli_query($conexao,"SELECT * FROM produto WHERE id_produto = '$idProduto'");
$produto = mysqli_fetch_assoc($consultaProduto);

$foto_antiga = 'imagens/' . $produto['foto'];
if (isset($foto_antiga)) {
    if (is_file($foto_antiga) && file_exists($foto_antiga)) {
        unlink($foto_antiga);
    }
}

$delete = mysqli_query($conexao, "DELETE FROM produto WHERE id_produto = '$idProduto'");

if ($delete) {
    $_SESSION['mensagem'] = "Produto Excluido com Sucesso!";
    header("Location: index.php");
    exit;
}
