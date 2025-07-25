<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if (isset($_POST['pesquisar'])) {
    $nome = $_POST['nome'];
    $consultaclientes = mysqli_query($conexao, "SELECT * FROM clientes WHERE nome LIKE '%$nome%' ORDER BY nome ASC ");
} else {
    $consultaclientes = mysqli_query($conexao, "SELECT * FROM clientes ORDER BY nome ASC");
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        .desativado {
            color: gray;
            text-decoration: line-through;
            text-decoration-color: red;
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
        <h2> <i class="fa-solid fa-people-group"></i> Clientes</h2>
        <p>Esta é a página de clientes. Aqui você pode gerenciar os clientes parceiros.</p>
        <?php
        echo ' <button class="btnAdicionar" onclick="window.location.href=\'adicionar.php\'"><i class="fas fa-plus"></i> Adicionar cliente</button>';
        ?>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/excel.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>
        <h3><i class="fa-solid fa-feather"></i> Pesquisar cliente</h3>

        <form action="" method="post" class="formulario" style="width: 100%;">
            <label>Pesquisar cliente</label>
            <input type="text" name="nome" placeholder="Pesquise clientes pelo nome aqui...">
            <button class="btnPesquisar" name="pesquisar">Pesquisar</button>
        </form>

        <h3><i class="fa-solid fa-feather"></i> clientes Cadastrados</h3>

        <table>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>telefone</th>
                <th>E-mail</th>
                <th>Endereço</th>
                <th colspan='3'>Ações</th>
            </tr>
            <?php

            if (mysqli_num_rows($consultaclientes) == 0) {
                echo "<tr><td colspan='7'>Nenhum cliente encontrado.</td></tr>";
            }
            while ($clientes = mysqli_fetch_assoc($consultaclientes)) {
                echo "<tr>";
                echo "<td>" . $clientes['nome'] . "</td>";
                echo "<td>" . $clientes['cpf'] . "</td>";
                echo "<td> <i class='fa fa-whatsapp' aria-hidden='true'></i> <a style='text-decoration:none;color:black;' href='https://api.whatsapp.com/send/?phone=55".$clientes['telefone']."'>". $clientes['telefone'] . "</a></td>";
                echo "<td>" . $clientes['email'] . "</td>";
                echo "<td>" . $clientes['endereco'] . "</td>";
                echo "<td>";
                if ($_SESSION['login']['setor'] === 'Gerência') {
                    echo "<button class='btnEditar' onclick='modalEditarCliente(" . $clientes['id_cliente'] . ")'><i class='fas fa-edit'></i> Editar</button>";
                    echo  "<button class='btnExcluir' onclick='excluirCliente(" . $clientes['id_cliente'] . ")'><i class='fas fa-trash'></i> Excluir</button>";
                }

                echo "<button class='btnemail' onclick='mandaremailCliente(\"" . htmlspecialchars($clientes['id_cliente']) . "\")'><i class='fa-solid fa-envelopes-bulk'></i> E-mail</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>
    <script>
        function modalEditarCliente(id) {
            // Redireciona para a página de edição do cliente
            window.location.href = "editar.php?id=" + id;
        }

        function excluirCliente(id) {
            if (confirm("Tem certeza que deseja excluir este cliente?")) {
                window.location.href = "excluir.php?id=" + id;
            }
        }

        function mandaremailCliente(id) {
            window.location.href = "mail/email.php?id=" + id;
        }
    </script>
</body>

</html>