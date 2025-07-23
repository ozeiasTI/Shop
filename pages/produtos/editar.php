<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$idProduto = $_GET['id'];

$consultaCategoria = mysqli_query($conexao, "SELECT * FROM categoria");
$consultaFornecedor = mysqli_query($conexao, "SELECT * FROM fornecedor");

$consultaProduto = mysqli_query($conexao,"  SELECT 
                                                produto.*,
                                                categoria.descricao AS descricao_categoria,
                                                categoria.id_categoria AS id_categoria,
                                                fornecedor.id_fornecedor AS id_fornecedor,
                                                fornecedor.nome AS nome_fornecedor
                                            FROM
                                                produto
                                            INNER JOIN categoria ON categoria.id_categoria = produto.categoria_id
                                            INNER JOIN fornecedor ON fornecedor.id_fornecedor = produto.fornecedor_id
                                            WHERE
                                                produto.id_produto = $idProduto");
$produto = mysqli_fetch_assoc($consultaProduto);


if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $preco_custo = $_POST['preco_custo'];
    $preco_venda = $_POST['preco_venda'];
    $estoque_total = $_POST['estoque_total'];
    $estoque_minimo = $_POST['estoque_minimo'];
    $categoria = $_POST['categoria'];
    $fornecedor = $_POST['fornecedor'];
    $ativo = $_POST['ativo'];

    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];

        $diretorio = 'imagens/';
        $caminhoCompleto = $diretorio . $foto;

        move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto);

        $foto_antiga = 'imagens/'. $produto['foto'];
        if (isset($foto_antiga)) {
            if (is_file($foto_antiga) && file_exists($foto_antiga)) {
                unlink($foto_antiga);
            }
        }

        $injecao = mysqli_query($conexao, "UPDATE produto SET nome = '$nome',categoria_id = '$categoria', preco_custo = $preco_custo, preco_venda = $preco_venda, estoque_total = $estoque_total, fornecedor_id = '$fornecedor', estoque_minimo = $estoque_minimo, ativo = '$ativo', foto = '$foto' WHERE id_produto = $idProduto");
    }else{
        $injecao = mysqli_query($conexao, "UPDATE produto SET nome = '$nome',categoria_id = '$categoria', preco_custo = $preco_custo, preco_venda = $preco_venda, estoque_total = $estoque_total, fornecedor_id = '$fornecedor', estoque_minimo = $estoque_minimo, ativo = '$ativo' WHERE id_produto = $idProduto");
    }

    
    if ($injecao) {
        $_SESSION['mensagem'] = "Cadastro Editado com Sucesso!";
        header("Location: index.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar produto</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        .foto {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto;
    display: block;
    margin-bottom: 20px;
}
    </style>
</head>

<body>
    <?php include_once("../../components/header.php") ?>
    <?php include_once("../../components/menu.php") ?>
    <main>
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
            unset($_SESSION['mensagem']);
        }
        ?>
        <h2><i class="fa-solid fa-plus"></i> Editar produto</h2>
        <p>Bem-vindo ao painel de Editar produto. Aqui você pode gerenciar os produtoes.</p>
        <form action="" method="post" class="formulario" enctype="multipart/form-data">
            <div class="foto">
                <?php
                    if (!empty($produto['foto'])) {
                        echo "<img src='imagens/" . $produto['foto'] . "' style='width: 100%;'>";
                    } else {
                        echo '<img src="/Shop/img/user.png" style="width: 100%;" alt="Foto de perfil">';
                    }
                ?>
            </div>
            
            <label>Nome</label>
            <input type="text" name="nome" value="<?php echo $produto['nome'];?>" required>
            
            <div class="group">
                <label>Preço de Custo</label>
                <input type="text" name="preco_custo" value="<?php echo $produto['preco_custo'];?>" required>
            </div>
            <div class="group">
                <label>Preço de Venda</label>
                <input type="text" name="preco_venda" value="<?php echo $produto['preco_venda'];?>" required>
            </div>
            <div class="group">
                <label>Estoque total</label>
                <input type="number" name="estoque_total" value="<?php echo $produto['estoque_total'];?>" required>
            </div>
            <div class="group">
                <label for="ativo">Ativo:</label>
                <select name="ativo" id="ativo">
                    <option value="Sim" <?php echo ($produto['ativo'] === 'Sim') ? 'selected' : ''; ?>>Sim</option>
                    <option value="Não" <?php echo ($produto['ativo'] === 'Não') ? 'selected' : ''; ?>>Não</option>
                </select>
            </div>
            <div class="group">
                <label>Fornecedor</label>
                <select name="fornecedor" required>
                    <option value="<?php echo $produto['id_fornecedor'] ;?>"><?php echo $produto['nome_fornecedor']; ?></option>
                    <?php
                    while ($fornecedor = mysqli_fetch_assoc($consultaFornecedor)) {
                        echo "<option value='" . $fornecedor['id_fornecedor'] . "'>" . $fornecedor['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="group">
                <label>Foto</label>
                <input type="file" name="foto">
            </div>
            <div class="group">
                <label>Estoque Mínimo</label>
                <input type="text" name="estoque_minimo" value="<?php echo $produto['estoque_minimo'];?>" required>
            </div>
            <div class="group">
                <label>Categoria</label>
                <select name="categoria" required>
                    <option value="<?php echo $produto['id_categoria']; ?>"><?php echo $produto['descricao_categoria']; ?></option>
                    <?php
                    while ($categorias = mysqli_fetch_assoc($consultaCategoria)) {
                        echo "<option value='" . $categorias['id_categoria'] . "'>" . $categorias['descricao'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            
            <button type="submit" class="btnSalvar" name="salvar"><i class="fas fa-plus"></i> Editar produto</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>

</body>

</html>