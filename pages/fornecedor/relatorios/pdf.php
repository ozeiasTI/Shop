<?php

session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

if (!isset($_SESSION['login'])) {
    header("Location: /Shop/index.php");
    exit;
}

// Classe PDF personalizada
class MYPDF extends TCPDF {
    public function Header() {
        $image_file = '../../../admin/empresa/imagens/'.$_SESSION['empresa']['logo'];

        if (file_exists($image_file)) {
            $this->Image($image_file, 10, 10, 35, '');
        }

        $this->SetY(10);
        $this->SetFont('helvetica', 'B', 14);
        $this->SetTextColor(0, 51, 102);
        $this->Cell(0, 5, $_SESSION['empresa']['nome'], 0, 1, 'C');

        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(0, 5, $_SESSION['empresa']['endereco'], 0, 1, 'C');
        $this->Cell(0, 5, $_SESSION['empresa']['telefone'], 0, 1, 'C');
        $this->Cell(0, 5, $_SESSION['empresa']['email'], 0, 1, 'C');
        $this->Cell(0, 5, $_SESSION['empresa']['cnpj'], 0, 1, 'C');
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Documento gerado automaticamente - Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages() .
            ' - ' . date('d/m/Y H:i'), 0, false, 'C');
    }
}

// Inicia o PDF
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($_SESSION['empresa']['nome']);
$pdf->SetTitle('Relatório de Fornecedores');
$pdf->SetMargins(15, 50, 15);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Estilo e início do HTML
$html = '
<style>
    h1 { color: #010440; text-align: center; margin-bottom: 20px; }
    table { border-collapse: collapse; width: 100%; }
    th {
        background-color: #010440;
        color: white;
        text-align: center;
        font-weight: bold;
    }
    td {
        text-align: center;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr.total {
        background-color: #ddd;
        font-weight: bold;
    }
</style>

<h1>Relatório de Fornecedores</h1>';

// Tabela
$html .= '<br><table border="1" cellpadding="5">
<tr>
    <th>Nome</th>
    <th>CNPJ</th>
    <th>Endereço</th>
    <th>Ramo</th>
    <th>E-mail</th>
</tr>';

$sql = "SELECT * FROM fornecedor ORDER BY nome ASC";


$res = $conexao->query($sql);
$totalfornecedor = 0;

while ($q = $res->fetch_assoc()) {
    $totalfornecedor++;
    $html .= '<tr>
        <td>' . htmlspecialchars($q['nome']) . '</td>
        <td>' . htmlspecialchars($q['cnpj']) . '</td>
        <td>' . htmlspecialchars($q['endereco']) . '</td>
        <td>' . htmlspecialchars($q['ramo']) . '</td>
        <td>' . htmlspecialchars($q['email']) . '</td>
    </tr>';
}

$html .= "<tr class='total'><td colspan='7'>Total de fornecedores</td><td>" . $totalfornecedor . "</td></tr>";
$html .= "</table>";

// Saída do PDF
$pdf->writeHTML($html, true, false, true, false, '');
$nome_arquivo = 'relatorio_fornecedor_' . date('Ymd_His') . '.pdf';
$pdf->Output($nome_arquivo, 'I');


?>
