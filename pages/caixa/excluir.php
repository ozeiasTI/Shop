<?php

session_start();
require_once("../../db/conexao.php");

$id_produto = $_GET['id_produto'];

array_splice($_SESSION['carrinho'], $id_produto, 1);

header("Location: index.php");
exit;

?>