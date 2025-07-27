<?php

require_once("../../db/conexao.php");
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

$idCliente = $_GET['id'];

$consultaCliente = mysqli_query($conexao, "SELECT * FROM clientes WHERE id_cliente = $idCliente");
$dadosCliente = mysqli_fetch_assoc($consultaCliente);

$consultaContas = mysqli_query($conexao, "SELECT * FROM contas WHERE identificador = $idCliente ORDER BY status_conta,data_acerto");

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
        <h2> <i class="fa-solid fa-people-group"></i> Contas em nome de <?php echo $dadosCliente['nome'] ?></h2>
        <p>Esta é a página de acerto de contas. Aqui você pode gerenciar os clientes parceiros com suas contas.</p>
        <button class="btnPDF" onclick="window.open('relatorios/pdf.php', '_blank')">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        <button class="btnEXCEL" onclick="window.open('relatorios/excel.php', '_blank')">
            <i class="fas fa-file-excel"></i> EXCEL
        </button>

        <h3><i class="fa-solid fa-feather"></i> <?php echo $dadosCliente['nome'] ?></h3>
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
        <table>
            <tr>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data Acerto</th>
                <th>Ações</th>
            </tr>
            <?php
            while ($contas = mysqli_fetch_assoc($consultaContas)) {
                if ($contas['data_acerto'] < date('Y-m-d') &&  $contas['status_conta'] == 'Aberta') {
                    echo "<tr style='color:red'>";
                } elseif ($contas['data_acerto'] >= date('Y-m-d') &&  $contas['status_conta'] == 'Aberta') {
                    echo "<tr style='color:black'>";
                } elseif ($contas['status_conta'] == 'Pago') {
                    echo "<tr style='color:green'>";
                }
                echo "<td>" . $contas['descricao_conta'] . "</td>";
                echo "<td>R$ " . $contas['valor'] . "</td>";
                echo "<td>" . date("d-m-Y", strtotime($contas['data_acerto'])) . "</td>";
                echo "<td>";
                echo "<a href='lancar.php?id=" . $contas['id_conta'] . "' title='Receber' style='margin-right:10px; color: #9029b9ff;'><i class='fa-solid fa-file-invoice-dollar'></i></a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>

    </main>
</body>

</html>