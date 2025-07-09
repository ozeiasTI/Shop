<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$consultaUsuarios = mysqli_query($conexao, "SELECT * FROM usuarios");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    </style>
</head>

<body>
    <?php include_once("../../components/header.php") ?>
    <?php include_once("../../components/menu.php") ?>
    <main>
        <?php
            if(isset($_SESSION['mensagem'])){
                echo "<h4 class='mensagem'>" . $_SESSION['mensagem'] . "</h4>";
                unset($_SESSION['mensagem']);
            }
        ?>
        <h2> <i class="fas fa-users"></i> Usuários</h2>
        <p>Esta é a página de usuários. Aqui você pode gerenciar os usuários do sistema.</p>
        <button class="btnAdicionar" onclick="window.location.href='adicionar.php'"><i class="fas fa-plus"></i> Adicionar Usuário</button>
        <table>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Função</th>
                <th>CPF</th>
                <th>Endereço</th>
                <th>Data de Cadastro</th>
                <th>Telefone</th>
                <th>Ativo</th>
                <?php
                    if($_SESSION['login']['funcao'] === 'Administrador'){
                        echo "<th colspan='2'>Ações</th>";
                    }
                 ?>
            </tr>
            <?php
            while ($usuarios = mysqli_fetch_assoc($consultaUsuarios)) {
                echo "<tr>";
                echo "<td>" . $usuarios['nome'] . "</td>";
                echo "<td>" . $usuarios['email'] . "</td>";
                echo "<td>" . $usuarios['funcao'] . "</td>";
                echo "<td>" . $usuarios['cpf'] . "</td>";
                echo "<td>" . $usuarios['endereco'] . "</td>";
                echo "<td>" . $usuarios['data_cadastro'] . "</td>";
                echo "<td>" . $usuarios['telefone'] . "</td>";
                echo "<td>" . $usuarios['ativo'] . "</td>";
                if($_SESSION['login']['funcao'] === 'Administrador'){
                    echo "<td>
                            <button class='btnEditar' onclick='modalEditarUsuario(" . $usuarios['id'] . ")'><i class='fas fa-edit'></i> Editar</button>
                            <button class='btnExcluir' onclick='excluirUsuario(" . $usuarios['id'] . ")'><i class='fas fa-trash'></i> Excluir</button>
                          </td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </main>
    <script>
        function modalEditarUsuario(id) {
            // Lógica para abrir o modal de edição
        }

        function excluirUsuario(id) {
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                window.location.href = "excluir.php?id=" + id;
            }
        }
    </script>
</body>

</html>