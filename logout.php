<?php

session_start();
require_once("db/conexao.php");

if (isset($_SESSION['login'])) {
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}

?>



