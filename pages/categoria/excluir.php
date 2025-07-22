<?php

session_start();
require_once("../../db/conexao.php");

$idCategoria = $_GET['id'];

$delete = mysqli_query($conexao,"DELETE FROM categoria WHERE id_categoria = '$idCategoria'");

if($delete){
    $_SESSION['mensagem'] = "Categoria excluída com sucesso!";
    header("Location: index.php");
    exit;
}


?>