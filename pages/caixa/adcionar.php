<?php

session_start();
require_once("../../db/conexao.php");

$id_produto = $_GET['id_produto'];

$consultaProduto = mysqli_query($conexao,"SELECT * FROM produto WHERE id_produto = '$id_produto'");
$dadosProduto = mysqli_fetch_assoc($consultaProduto);

$nomeProduto = $dadosProduto['nome'];
$categoriaProduto = $dadosProduto['categoria_id'];
$preco_vendaProduto = $dadosProduto['preco_venda'];

if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])){
    foreach($_SESSION['carrinho'] as $chave => $valor){
        if($valor['id'] === $id_produto){
            $_SESSION['carrinho'][$chave]['quantidade'] += 1;
            header("Location: index.php");
            exit;
        }
    }
} 

$_SESSION['carrinho'][] = [
    "id" => $id_produto,
    "nome" => $nomeProduto,
    "categoria" => $categoriaProduto,
    "preco" => $preco_vendaProduto,
    "quantidade" => 1
];

header("Location: index.php");
exit;


?>