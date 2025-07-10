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
            $this->Image($image_file, 10, 10, 35, '', 'PNG');
        }

        $this->SetY(10);
        $this->SetFont('helvetica', 'B', 14);
        $this->SetTextColor(0, 51, 102);
        $this->Cell(0, 5, 'Pousada Entre Rios', 0, 1, 'C');

        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(0, 5, 'Endereço: LINHA 11, S/N RIO GUAPORÉ - ZONA RURAL, CABIXI/RO', 0, 1, 'C');
        $this->Cell(0, 5, 'Telefone: (69) 9357-0338', 0, 1, 'C');
        $this->Cell(0, 5, 'E-mail: pousadaentrerioscabixi@gmail.com', 0, 1, 'C');
        $this->Ln(5);
    }

    public function Footer() {
        date_default_timezone_set('America/Cuiaba');
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Documento gerado automaticamente - Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages() .
            ' - ' . date('d/m/Y H:i'), 0, false, 'C');
    }
}

// Inicia o PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistema da Pousada');
$pdf->SetTitle('Relatório de Quartos');
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
<h1>Relatório de Quartos</h1>';

// Tabela
$html .= '<br><table border="1" cellpadding="5">
<tr>
    <th>Nome</th>
    <th>Tipo</th>
    <th>Descrição</th>
    <th>Valor Diária</th>
</tr>';

// Consulta SQL com filtros
$sql = mysqli_query($conexao,"SELECT * FROM usuarios");

$res = $conexao->query($sql);
$totalUsuarios = 0;

while ($q = $res->fetch_assoc()) {
    $totalUsuarios++;
    $html .= '<tr>
        <td>' . htmlspecialchars($q['numero']) . '</td>
        <td>' . htmlspecialchars($q['tipo']) . '</td>
        <td>' . htmlspecialchars($q['descricao']) . '</td>
        <td>R$ ' . number_format($q['valor_diaria'], 2, ',', '.') . '</td>
    </tr>';
}

$html .= "<tr class='total'><td colspan='3'>Total de Quartos</td><td>" . $totalQuartos . "</td></tr>";
$html .= "</table>";

// Saída do PDF
$pdf->writeHTML($html, true, false, true, false, '');
$nome_arquivo = 'relatorio_quartos_' . date('Ymd_His') . '.pdf';
$pdf->Output($nome_arquivo, 'I');


?>
