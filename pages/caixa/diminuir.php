<?php

session_start();
require_once("../../db/conexao.php");

$chave = $_GET['chave'];

foreach($_SESSION['carrinho'] AS $key => $valor){
    if($key == $chave){
        $_SESSION['carrinho'][$key]['quantidade'] -= 1;
        if($_SESSION['carrinho'][$key]['quantidade'] <= 0){
            array_splice($_SESSION['carrinho'],$key,1);
        }
        header("Location: index.php");
        exit;
    }
}

?>