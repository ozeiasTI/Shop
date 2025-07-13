<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

if (isset($_POST['pesquisar'])) {
    $chave = $_POST['chave'];
    $consultaUsuarios = mysqli_query($conexao, "SELECT * FROM usuarios WHERE nome LIKE '%$chave%' ORDER BY ativo DESC,nome ASC ");
} else {
    $consultaUsuarios = mysqli_query($conexao, "SELECT * FROM usuarios ORDER BY ativo DESC,nome ASC");
}


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
        <h2> <i class="fas fa-users"></i> Usuários</h2>
        <p>Esta é a página de usuários. Aqui você pode gerenciar os usuários do sistema.</p>
        <?php
        if ($_SESSION['login']['setor'] === 'Gerência') {
            echo ' <button class="btnAdicionar" onclick="window.location.href=\'adicionar.php\'"><i class="fas fa-plus"></i> Adicionar Usuário</button>';
        }
        ?>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/planilha.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>
        <button class="btnNotificar" onclick="window.location.href='notificacao/notificacao.php'">
            <i class="fa-solid fa-bell"></i> NOTIFICAR
        </button>
        <h3><i class="fa-solid fa-feather"></i> Pesquisar Usuário</h3>
        <form action="" method="post" class="formulario" style="width: 100%;">
            <label>Pesquisar Usuário</label>
            <input type="text" name="chave" placeholder="Pesquise usuarios pelo nome aqui...">
            <button class="btnPesquisar" name="pesquisar">Pesquisar</button>
        </form>

        <h3><i class="fa-solid fa-feather"></i> Usuários Cadastrados</h3>

        <table>
            <tr>
                <th>Nome</th>
                <th>Função</th>
                <th>Setor</th>
                <th>Endereço</th>
                <th>Tempo de Serviço</th>
                <th>Telefone</th>
                <th colspan='3'>Ações</th>
            </tr>
            <?php
            function tempoDesde($data_cadastro)
            {
                $data = new DateTime($data_cadastro);
                $agora = new DateTime();
                $intervalo = $agora->diff($data);

                $partes = [];

                if ($intervalo->y > 0) $partes[] = $intervalo->y . ' ano' . ($intervalo->y > 1 ? 's' : '');
                if ($intervalo->m > 0) $partes[] = $intervalo->m . ' mês' . ($intervalo->m > 1 ? 'es' : '');
                if ($intervalo->d > 0 && $intervalo->y == 0) $partes[] = $intervalo->d . ' dia' . ($intervalo->d > 1 ? 's' : '');

                if (empty($partes)) return 'Hoje';

                return implode(', ', $partes) . ' atrás';
            }

            if (mysqli_num_rows($consultaUsuarios) == 0) {
                echo "<tr><td colspan='7'>Nenhum usuário encontrado.</td></tr>";
            }
            while ($usuarios = mysqli_fetch_assoc($consultaUsuarios)) {
                if ($usuarios['ativo'] == 'NÃO') {
                    echo "<tr class='desativado'>";
                } else {
                    echo "<tr>";
                }
                echo "<td>" . $usuarios['nome'] . "</td>";
                echo "<td>" . $usuarios['funcao'] . "</td>";
                echo "<td>" . $usuarios['setor'] . "</td>";
                echo "<td>" . $usuarios['endereco'] . "</td>";
                echo "<td>" . tempoDesde($usuarios['data_cadastro']) . "</td>";
                echo "<td><a style='text-decoration:none;' href='https://api.whatsapp.com/send/?phone=55".$usuarios['telefone']."'>". $usuarios['telefone'] . "</a></td>";
                echo "<td>";
                if ($_SESSION['login']['setor'] === 'Gerência') {
                    echo "<button class='btnEditar' onclick='modalEditarUsuario(" . $usuarios['id'] . ")'><i class='fas fa-edit'></i> Editar</button>";
                    echo  "<button class='btnExcluir' onclick='excluirUsuario(" . $usuarios['id'] . ")'><i class='fas fa-trash'></i> Excluir</button>";
                }

                echo "<button class='btnemail' onclick='mandaremailUsuario(\"" . htmlspecialchars($usuarios['email']) . "\")'><i class='fa-solid fa-envelopes-bulk'></i> E-mail</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>
    <script>
        function modalEditarUsuario(id) {
            // Redireciona para a página de edição do usuário
            window.location.href = "editar.php?id=" + id;
        }

        function excluirUsuario(id) {
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                window.location.href = "excluir.php?id=" + id;
            }
        }

        function mandaremailUsuario(email) {
            window.location.href = "mail/email.php?email=" + email;
        }
    </script>
</body>

</html>