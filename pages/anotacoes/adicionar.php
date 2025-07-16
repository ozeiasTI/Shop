<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if(isset($_POST['salvar'])){
    $titulo = $_POST['titulo'];
    $data_conclusao = $_POST['data_conclusao'];
    $mensagem = $_POST['mensagem'];
    $categoria = $_POST['categoria'];
    $status = $_POST['status'];

    $meuID = $_SESSION['login']['id'];
    $injecao = mysqli_query($conexao, "INSERT INTO anotacoes(usuario_id,titulo,mensagem,categoria_anotacoes,data_execucao,status_anotacoes)VALUES($meuID,'$titulo','$mensagem','$categoria','$data_conclusao','$status')");
    if($injecao){
        $_SESSION['mensagem'] = "Anotação Cadastrada com sucesso!";
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
    <title>Adicionar Anotação</title>
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
        <h2><i class="fa-solid fa-notes-medical"></i> Adicionar Anotação</h2>
        <p>Preencha o formulário abaixo para adicionar uma nova Anotação.</p>
        <h3><i class="fa-solid fa-clipboard"></i> Adicionar Anoatção</h3>

        <form action="" method="post" class="formulario">
            <div class="group">
                <label>Título:</label>
                <input type="text" name="titulo" required placeholder="Digite o título...">
            </div>
            <div class="group">
                <label>Data Conclusão:</label>
                <input type="date" name="data_conclusao">
            </div>

            <label>Mensagem:</label>
            <textarea name="mensagem" rows="6"></textarea>

            <div class="group">
                <label>Categoria:</label>
                <select name="categoria">
                    <option value="">-- Selecione uma categoria --</option>
                    <option value="ideias">Ideias</option>
                    <option value="tarefas">Tarefas</option>
                    <option value="estudos">Estudos</option>
                    <option value="trabalho">Trabalho</option>
                    <option value="projetos">Projetos</option>
                    <option value="pessoal">Pessoal</option>
                    <option value="lembretes">Lembretes</option>
                    <option value="financeiro">Financeiro</option>
                    <option value="reuniões">Reuniões</option>
                    <option value="importante">Importante</option>
                    <option value="urgente">Urgente</option>
                    <option value="eventos">Eventos</option>
                    <option value="compras">Lista de Compras</option>
                    <option value="saude">Saúde</option>
                    <option value="outros">Outros</option>
                </select>
            </div>
            <div class="group">
                <label>Status</label>
                <select name="status" id="status">
                    <option value="">-- Selecione o status --</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Em andamento">Em andamento</option>
                    <option value="Concluída">Concluída</option>
                    <option value="Cancelada">Cancelada</option>
                    <option value="Postergada">Postergada</option>
                    <option value="Prioritária">Prioritária</option>
                    <option value="Arquivada">Arquivada</option>
                </select>
            </div>
            <button type="submit" class="btnSalvar" name="salvar"><i class="fas fa-plus"></i> Adicionar Anotação</button>
            <button type="button" class="btnCancelar" onclick="window.location.href='index.php'"><i class="fas fa-times"></i> Cancelar</button>
        </form>
    </main>
</body>

</html>