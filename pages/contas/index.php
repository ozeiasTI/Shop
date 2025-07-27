<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}
$meuID = $_SESSION['login']['id'];

if (isset($_POST['pesquisar'])) {
    $conta = mysqli_real_escape_string($conexao, $_POST['conta']);
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    $sql = "SELECT * FROM contas WHERE descricao_conta LIKE '%$conta%'";

    if (!empty($data_inicio) && !empty($data_fim)) {
        $sql .= " AND data_acerto BETWEEN '$data_inicio' AND '$data_fim'";
    } elseif (!empty($data_inicio)) {
        $sql .= " AND data_acerto >= '$data_inicio'";
    } elseif (!empty($data_fim)) {
        $sql .= " AND data_acerto <= '$data_fim'";
    }

    $sql .= " ORDER BY status_conta, data_acerto";

    $consultaContas = mysqli_query($conexao, $sql);
} else {
    $consultaContas = mysqli_query($conexao, "SELECT * FROM contas ORDER BY status_conta, data_acerto");
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas</title>
    <link rel="stylesheet" href="/Shop/css/padrao.css">
    <link rel="shortcut icon" href="/Shop/img/login.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/8ec7b849f5.js" crossorigin="anonymous"></script>
    <style>
        .dashboard-cards {
            margin-top: 20px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            padding: 20px;
            border-radius: 40px 8px 40px 8px;
            flex: 1;
            text-align: center;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .card h4 {
            margin-bottom: 10px;
            font-size: 20px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
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
        <h2><i class="fa-solid fa-sack-dollar"></i> Contas</h2>
        <p>Bem-vindo ao painel de Contas. Aqui você pode gerenciar todas as suas contas.</p>
        <button class="btnAdicionar" onclick="window.location.href='adicionar.php'"> + Adcionar Conta</button>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/excel.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>
        <h3><i class="fa-solid fa-sack-dollar"></i> Contas no mês de { <?php echo date("M") ?> }</h3>

        <div class="dashboard-cards">
            <div class="card" style="background-color: #8cf0daff;">
                <h4>Contas a Receber</h4>
                <?php
                $consultacontasentrada = mysqli_query($conexao, "SELECT SUM(valor) AS entradas FROM contas WHERE tipo = 'Entrada' AND status_conta = 'Aberta' AND MONTH(data_acerto) = MONTH(CURDATE()) AND YEAR(data_acerto) = YEAR(CURDATE())");
                $resultadoentrada = mysqli_fetch_assoc($consultacontasentrada);
                echo "<p style='color:green;'>R$ " . $resultadoentrada['entradas'] . "</p>";
                ?>
            </div>
            <div class="card" style="background-color: #8cf0daff;">
                <h4>Contas já recebidas</h4>
                <?php
                $consultacontasentradarecebidas = mysqli_query($conexao, "SELECT SUM(valor) AS entradas FROM contas WHERE tipo = 'Entrada' AND status_conta = 'Pago' AND MONTH(data_acerto) = MONTH(CURDATE()) AND YEAR(data_acerto) = YEAR(CURDATE())");
                $resultadoentradarecebida = mysqli_fetch_assoc($consultacontasentradarecebidas);
                echo "<p style='color:green;'>R$ " . $resultadoentradarecebida['entradas'] . "</p>";
                ?>
            </div>
            <div class="card" style="background-color: #8cf0daff;">
                <h4>Contas a Pagar</h4>
                <?php
                $consultacontassaida = mysqli_query($conexao, "SELECT SUM(valor) AS saidas FROM contas WHERE tipo = 'Saída' AND status_conta = 'Aberta' AND MONTH(data_acerto) = MONTH(CURDATE()) AND YEAR(data_acerto) = YEAR(CURDATE())");
                $resultadosaida = mysqli_fetch_assoc($consultacontassaida);
                echo "<p style='color:red;'>R$ " . $resultadosaida['saidas'] . "</p>";
                ?>
            </div>
            <div class="card" style="background-color: #8cf0daff;">
                <h4>Contas já pagas</h4>
                <?php
                $consultacontassaidapagas = mysqli_query($conexao, "SELECT SUM(valor) AS saidas FROM contas WHERE tipo = 'Saída' AND status_conta = 'Pago' AND MONTH(data_acerto) = MONTH(CURDATE()) AND YEAR(data_acerto) = YEAR(CURDATE())");
                $resultadosaidapagas = mysqli_fetch_assoc($consultacontassaidapagas);
                echo "<p style='color:red;'>R$ " . $resultadosaidapagas['saidas'] . "</p>";
                ?>
            </div>
            <div class="card" style="background-color: #8cf0daff;">
                <h4>Expectativa de Lucro</h4>
                <?php
                $valorTotalMensal = ($resultadoentrada['entradas'] + $resultadoentradarecebida['entradas']) - (- ($resultadosaida['saidas'] + $resultadosaidapagas['saidas']));
                echo "<p style='color:blue;'>R$ " . $valorTotalMensal . "</p>";
                ?>
            </div>
        </div>

        <h3><i class="fa-solid fa-sack-dollar"></i> Todos os Registros</h3>

        <form action="" method="post" class="formulario" style="width: 100%;">
            <label>Pesquisar Conta</label>
            <input type="text" name="conta" placeholder="Pesquise conta pelo nome aqui...">

            <div class="group">
                <label>Data Inicial</label>
                <input type="date" name="data_inicio">
            </div>
            <div class="group">
                <label>Data Final</label>
                <input type="date" name="data_fim">
            </div>

            <button class="btnPesquisar" name="pesquisar">Pesquisar</button>
        </form>

        <div style="margin: 10px 0 20px; display: flex; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center;">
                <span style="width: 15px; height: 15px; background-color: #e74c3c; display: inline-block; margin-right: 5px;"></span> Vencida
            </div>
            <div style="display: flex; align-items: center;">
                <span style="width: 15px; height: 15px; background-color: #0f0a01ff; display: inline-block; margin-right: 5px;"></span> Em andamento
            </div>
            <div style="display: flex; align-items: center;">
                <span style="width: 15px; height: 15px; background-color: #2ecc71; display: inline-block; margin-right: 5px;"></span> Paga
            </div>
        </div>
        <?php
        if ($consultaContas->num_rows > 0) {
            $valorTotal = 0;
            echo "<table>";
            echo "<tr><th>Nome</th><th>Descrição</th><th>Tipo</th><th>Valor</th><th>Status</th><th>Data Acerto</th><th>Forma de Acerto</th><th>Ações</th></tr>";
            while ($contas = mysqli_fetch_assoc($consultaContas)) {

                if ($contas['data_acerto'] < date('Y-m-d') &&  $contas['status_conta'] == 'Aberta') {
                    echo "<tr style='color:red'>";
                } elseif ($contas['data_acerto'] >= date('Y-m-d') &&  $contas['status_conta'] == 'Aberta') {
                    echo "<tr style='color:black'>";
                } elseif ($contas['status_conta'] == 'Pago') {
                    echo "<tr style='color:green'>";
                }
                if ($contas['identificador'] > 1) {
                    $idCliente = $contas['identificador'];
                    $consultaClientes = mysqli_query($conexao, "SELECT * FROM clientes WHERE id_cliente = $idCliente");
                    $cliente = mysqli_fetch_assoc($consultaClientes);
                    echo "<td>" . $cliente['nome'] . "</td>";
                }
                echo "<td>" . $contas['descricao_conta'] . "</td>";
                echo "<td>" . $contas['tipo'] . "</td>";
                echo "<td>R$ " . $contas['valor'] . "</td>";
                echo "<td>" . $contas['status_conta'] . "</td>";
                echo "<td>" . date('d-m-Y', strtotime($contas['data_acerto'])) . "</td>";
                echo "<td>" . $contas['forma_acerto'] . "</td>";
                echo "<td>";
                if ($contas['status_conta'] == 'Pago') {
                    echo "<span>✅ PAGO</span>";
                } else {
                    echo "<a href='editar.php?id=" . $contas['id_conta'] . "' title='Editar' style='margin-right:10px; color: #2980b9;'><i class='fa-solid fa-pencil'></i></a>";
                    echo "<a href='excluir.php?id=" . $contas['id_conta'] . "' title='Excluir' style='margin-right:10px; color: #c0392b;'><i class='fa-solid fa-trash'></i></a>";
                    echo "<a href='duplicar.php?id=" . $contas['id_conta'] . "' title='Duplicar' style='margin-right:10px; color: #29b965ff;'><i class='fa-solid fa-copy'></i></a>";
                    echo "<a href='lancar.php?id=" . $contas['id_conta'] . "' title='Pagar / Receber' style='margin-right:10px; color: #9029b9ff;'><i class='fa-solid fa-file-invoice-dollar'></i></a>";
                }
                echo "</td>";
                echo "</tr>";

                if ($contas['status_conta'] == 'Aberta') {
                    $valorTotal += $contas['valor'];
                }
            }
            echo "<tr><td colspan='7' style='font-weight:bold;'>Valor total da soma dos Registros de Contas a Pagar e a Receber em Aberto</td><td>R$ " . number_format($valorTotal, 2) . "</td></tr>";
            echo "</table>";
        } else {
            echo "Não há contas Cadastradas";
        }
        ?>

    </main>
</body>

</html>