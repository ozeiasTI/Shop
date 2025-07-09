<?php

session_start();
require_once("../../../db/conexao.php");

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}
?>