<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$consultaCategorias = mysqli_query($conexao, "SELECT * FROM categoria");

if(isset($_POST['pesquisar'])){
    $categoria = $_POST['categoria'];
    $consultaPrdoutos = mysqli_query($conexao, "SELECT * FROM produto WHERE categoria_id LIKE '%$categoria%'");
}else{
     $consultaPrdoutos = mysqli_query($conexao, "SELECT * FROM produto");
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixa</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        main {
            padding: 0;
        }

        .caixa_header {
            display: flex;
            height: 6.5vh;
            justify-content: space-between;
            align-items: center;
            background-color: #1e1e2ff6;
            padding: 10px;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 20px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .caixa_header a {
            color: white;
            font-size: 22px;
            text-decoration: none;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            border: 1px solid white;
            padding: 8px;
        }

        .caixa_header a:hover {
            background-color: #2b788694;
        }

        #produtos {
            width: 75%;
            height: 85.5vh;
            float: left;
            background-color: #1e1e2ff6;
            overflow-y: auto;
        }

        #financeiro {
            width: 25%;
            height: 85.5vh;
            float: left;
        }

        #categorias {
            padding: 8px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #1e1e2ff6;
        }

        .categorias-form {
            flex: 1;
            text-align: center;
        }

        .categorias-form input {
            width: 100%;
            height: 50px;
            cursor: pointer;
            background-color: white;
            font-weight: bold;
            font-size: 16px;
            border: none;
        }

        .categorias-form input:hover {
            background-color: #1e7180cb;
            color: white;
        }
        .listaPrdutos{
            border-top: 1px solid white;
        }
        .produto{
           background-color: white;
            width: 18%;
            margin: 1%;
            height: 95px;
            float: left;
            border-radius: 5px;
            cursor: pointer;
        }
        .produto:hover{
            box-shadow: rgba(28, 133, 253, 0.63) 0px 0px 0px 3px;
        }
        .produto_foto{
            width: 50%;
            height: 95px;
            float: left;
            border-radius: 5px;
            padding: 2px;
        }
        .produto_info{
            text-align: center;
            margin-top: 10px;
            padding: 2px;
        }
    </style>
</head>

<body>
    <?php include_once("../../components/header.php") ?>
    <?php include_once("../../components/menu.php") ?>
    <main>
        <div class="caixa_header">
            <h2 style="color: white;"> Caixa</h2>
            <div>
                <a style="color: white;background-color:#1e7180cb;" href="index.php"><i class="fa-solid fa-cash-register"></i> Venda</a>
                <a style="color: white;" href="index.php"><i class="fa-solid fa-dollar-sign"></i> Caixa</a>
            </div>
        </div>
        <div id="produtos">
            <div id="categorias">
                <?php
                echo "<form action='' method='post' class='categorias-form'>";

                echo "<input type='hidden' name='categoria' value=''>";
                echo "<input type='submit' value='TODAS' name='pesquisar'>";

                echo "</form>";
                while ($categorias = mysqli_fetch_assoc($consultaCategorias)) {
                    echo "<form action='' method='post' class='categorias-form'>";

                    echo "<input type='hidden' name='categoria' value='" . $categorias['id_categoria'] . "'>";
                    echo "<input type='submit' value='" . $categorias['descricao'] . "' name='pesquisar'>";

                    echo "</form>";
                }
                ?>
            </div>
            <div class="listaPrdutos">
                <?php
                while ($produtos = mysqli_fetch_assoc($consultaPrdoutos)) {
                    echo "<div class='produto' onclick='adicionar({$produtos['id_produto']})'>";

                    echo "<div class ='produto_foto'>";
                    if(!empty($produtos['foto'])){
                        echo "<img style='max-height:80px;' src='../produtos/imagens/".$produtos['foto']."'>";
                    }else{
                        echo "<img style='max-height:80px;' src='/Shop/img/sem-foto.png'>";
                    }
                    echo "</div>";

                    echo "<div class ='produto_info'>";
                    echo "<p>".$produtos['nome']."</p>";
                    echo "<p>R$ ".$produtos['preco_venda']."</p>";
                    echo "</div>";
                    
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div id="financeiro">

        </div>
        <script>
            function adicionar(id){
                alert("Você clicou no id: " + id);
            }
        </script>        
    </main>

</body>

</html>