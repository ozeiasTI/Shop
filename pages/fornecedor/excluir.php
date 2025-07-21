<?php

session_reset();
require_once("../../db/conexao.php");

$idFornecedor = $_GET['id'];

$delete = mysqli_query($conexao,"DELETE FROM fornecedor WHERE id_fornecedor = $idFornecedor");

if($delete){
    $_SESSION['mensagem'] = "Usuario deleteado com sucesso!";
    header("Location: index.php");
    exit;
}

?>