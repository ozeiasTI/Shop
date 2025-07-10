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
$pdf->SetTitle('Relatório de Usuarios');
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
<h1>Relatório de Usuários</h1>';

// Tabela
$html .= '<br><table border="1" cellpadding="5">
<tr>
    <th>Nome</th>
    <th>E-mail</th>
    <th>Função</th>
    <th>CPF</th>
    <th>Telefone</th>
    <th>Idade</th>
    <th>Atividade</th>
    <th>Endereço</th>
</tr>';

$sql = "SELECT * FROM usuarios WHERE ativo = 'SIM'";

$res = $conexao->query($sql);
$totalUsuarios = 0;

function calcularIdade($data_nascimento) {
    $data_nasc = new DateTime($data_nascimento);
    $hoje = new DateTime();
    $idade = $hoje->diff($data_nasc)->y;
    return $idade;
}
function tempoDesde($data_cadastro) {
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


while ($q = $res->fetch_assoc()) {
    $totalUsuarios++;
    $html .= '<tr>
        <td>' . htmlspecialchars($q['nome']) . '</td>
        <td>' . htmlspecialchars($q['email']) . '</td>
        <td>' . htmlspecialchars($q['funcao']) . '</td>
        <td>' . htmlspecialchars($q['cpf']) . '</td>
        <td>' . htmlspecialchars($q['telefone']) . '</td>
        <td>' . calcularIdade($q['data_nascimento']) . ' anos</td>
        <td>' . tempoDesde($q['data_cadastro']) . '</td>
        <td>' . htmlspecialchars($q['endereco']) . '</td>
    </tr>';
}

$html .= "<tr class='total'><td colspan='7'>Total de Usuários</td><td>" . $totalUsuarios . "</td></tr>";
$html .= "</table>";

// Saída do PDF
$pdf->writeHTML($html, true, false, true, false, '');
$nome_arquivo = 'relatorio_quartos_' . date('Ymd_His') . '.pdf';
$pdf->Output($nome_arquivo, 'I');


?>
