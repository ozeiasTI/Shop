<?php

session_start();
require_once("../../db/conexao.php");

$id = $_GET['id'];

$delete = mysqli_query($conexao, "DELETE FROM usuarios WHERE id = $id");

if($delete){
    $_SESSION['mensagem'] = "Usuário deletado com sucesso!";
    header("Location: usuarios.php");
    exit;
}

?>