<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$id = $_GET['id'];

$consultaAnotacao = mysqli_query($conexao, "SELECT * FROM anotacoes WHERE id_anotacoes = $id");
$anotacao = mysqli_fetch_assoc($consultaAnotacao);

if (isset($_POST['salvar'])) {
    $titulo = $_POST['titulo'];
    $data_conclusao = $_POST['data_conclusao'];
    $mensagem = $_POST['mensagem'];
    $categoria = $_POST['categoria'];
    $status = $_POST['status'];

    $meuID = $_SESSION['login']['id'];

    $injecao = mysqli_query($conexao, "
    UPDATE anotacoes 
    SET 
        usuario_id = $meuID,
        titulo = '$titulo',
        mensagem = '$mensagem',
        categoria_anotacoes = '$categoria',
        data_execucao = '$data_conclusao',
        status_anotacoes = '$status'
    WHERE id_anotacoes = $id
");

    if ($injecao) {
        $_SESSION['mensagem'] = "Anotação Editada com sucesso!";
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
    <title>Editar Anotação</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
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
        <h2><i class="fa-solid fa-pen-to-square"></i> Editar Anotação</h2>
        <p>Preencha o formulário abaixo para editar uma Anotação.</p>
        <h3><i class="fa-solid fa-pen-to-square"></i> Editar Anoatção</h3>

        <form action="" method="post" class="formulario">
            <div class="group">
                <label>Título:</label>
                <input type="text" name="titulo" required value="<?php echo $anotacao['titulo']; ?>">
            </div>
            <div class="group">
                <label>Data Conclusão:</label>
                <input type="date" name="data_conclusao" value="<?php echo $anotacao['data_execucao']; ?>">
            </div>

            <label>Mensagem:</label>
            <textarea name="mensagem" rows="6"><?php echo htmlspecialchars($anotacao['mensagem']); ?></textarea>

            <div class="group">
                <label>Categoria:</label>
                <select name="categoria">
                    <option value="Ideias" <?php echo ($anotacao['categoria_anotacoes'] === 'Ideias') ? 'selected' : ''; ?>>Ideias</option>
                    <option value="tarefas" <?php echo ($anotacao['categoria_anotacoes'] === 'tarefas') ? 'selected' : ''; ?>>Tarefas</option>
                    <option value="estudos" <?php echo ($anotacao['categoria_anotacoes'] === 'estudos') ? 'selected' : ''; ?>>Estudos</option>
                    <option value="trabalho" <?php echo ($anotacao['categoria_anotacoes'] === 'trabalho') ? 'selected' : ''; ?>>Trabalho</option>
                    <option value="projetos" <?php echo ($anotacao['categoria_anotacoes'] === 'projetos') ? 'selected' : ''; ?>>Projetos</option>
                    <option value="pessoal" <?php echo ($anotacao['categoria_anotacoes'] === 'pessoal') ? 'selected' : ''; ?>>Pessoal</option>
                    <option value="lembretes" <?php echo ($anotacao['categoria_anotacoes'] === 'lembretes') ? 'selected' : ''; ?>>Lembretes</option>
                    <option value="financeiro" <?php echo ($anotacao['categoria_anotacoes'] === 'financeiro') ? 'selected' : ''; ?>>Financeiro</option>
                    <option value="reuniões" <?php echo ($anotacao['categoria_anotacoes'] === 'reuniões') ? 'selected' : ''; ?>>Reuniões</option>
                    <option value="importante" <?php echo ($anotacao['categoria_anotacoes'] === 'importante') ? 'selected' : ''; ?>>Importante</option>
                    <option value="urgente" <?php echo ($anotacao['categoria_anotacoes'] === 'urgente') ? 'selected' : ''; ?>>Urgente</option>
                    <option value="eventos" <?php echo ($anotacao['categoria_anotacoes'] === 'eventos') ? 'selected' : ''; ?>>Eventos</option>
                    <option value="compras" <?php echo ($anotacao['categoria_anotacoes'] === 'compras') ? 'selected' : ''; ?>>Compras</option>
                    <option value="saude" <?php echo ($anotacao['categoria_anotacoes'] === 'saude') ? 'selected' : ''; ?>>Saúde</option>
                    <option value="outros" <?php echo ($anotacao['categoria_anotacoes'] === 'outros') ? 'selected' : ''; ?>>Outros</option>

                </select>
            </div>
            <div class="group">
                <label>Status</label>
                <select name="status" id="status">
                    <option value="Pendente" <?php echo ($anotacao['status_anotacoes'] === 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Em andamento" <?php echo ($anotacao['status_anotacoes'] === 'Em andamento') ? 'selected' : ''; ?>>Em andamento</option>
                    <option value="Concluída" <?php echo ($anotacao['status_anotacoes'] === 'Concluída') ? 'selected' : ''; ?>>Concluída</option>
                    <option value="Cancelada" <?php echo ($anotacao['status_anotacoes'] === 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                    <option value="Postergada" <?php echo ($anotacao['status_anotacoes'] === 'Postergada') ? 'selected' : ''; ?>>Postergada</option>
                    <option value="Prioritária" <?php echo ($anotacao['status_anotacoes'] === 'Prioritária') ? 'selected' : ''; ?>>Prioritária</option>
                    <option value="Arquivada" <?php echo ($anotacao['status_anotacoes'] === 'Arquivada') ? 'selected' : ''; ?>>Arquivada</option>

                </select>
            </div>
            <button type="submit" class="btnSalvar" name="salvar"><i class="fa-solid fa-pen-to-square"></i> Editar Anotação</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>
</body>

</html>