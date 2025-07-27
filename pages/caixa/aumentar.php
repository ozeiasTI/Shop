<?php

session_start();
require_once("../../db/conexao.php");

$chave = $_GET['chave'];

foreach ($_SESSION['carrinho'] as $key => $valor) {
    if ($key == $chave) {
        $id_produto = $_SESSION['carrinho'][$key]['id'];

        $consultaEstoque = mysqli_query($conexao, "SELECT estoque_total FROM produto WHERE id_produto = $id_produto");
        $estoque = mysqli_fetch_assoc($consultaEstoque);
        $estoque_atual = $estoque['estoque_total'];

        if ($estoque_atual > $_SESSION['carrinho'][$key]['quantidade']) {
            $_SESSION['carrinho'][$key]['quantidade'] += 1;
        } else {
            $_SESSION['mensagem'] = "Estoque limite atingido para o produto selecionado!";
        }
        header("Location: index.php");
        exit;
    }
}
