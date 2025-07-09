<?php

session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$consultaUsuarios = mysqli_query($conexao,"SELECT * FROM usuarios");

$pdf = new TCPDF();

$pdf -> AddPage();

$pdf -> setFont('helvetica', '', 12);

$pdf -> Write(0, 'Olá isso é um PDF gerado com sucesso');

$pdf -> Output('arquivo.pdf', 'I');

?>