<?php
session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Função para calcular idade
function calcularIdade($data_nascimento) {
    $data = new DateTime($data_nascimento);
    $hoje = new DateTime();
    return $hoje->diff($data)->y;
}

// Função para tempo desde o cadastro
function tempoDesde($data_cadastro) {
    $data = new DateTime($data_cadastro);
    $agora = new DateTime();
    $intervalo = $agora->diff($data);

    $partes = [];
    if ($intervalo->y > 0) $partes[] = $intervalo->y . ' ano' . ($intervalo->y > 1 ? 's' : '');
    if ($intervalo->m > 0) $partes[] = $intervalo->m . ' mês' . ($intervalo->m > 1 ? 'es' : '');
    if ($intervalo->d > 0 && $intervalo->y == 0) $partes[] = $intervalo->d . ' dia' . ($intervalo->d > 1 ? 's' : '');

    return empty($partes) ? 'Hoje' : implode(', ', $partes) . ' atrás';
}

// Consulta os usuários
$sql = "SELECT * FROM usuarios ORDER BY ativo DESC,nome ASC";
$resultado = mysqli_query($conexao, $sql);

// Cria nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Usuários Ativos');

// Cabeçalhos
$cabecalhos = ['Nome', 'E-mail', 'Função', 'CPF', 'Telefone', 'Idade', 'Atividade', 'Endereço', 'ativo'];
$coluna = 'A';
foreach ($cabecalhos as $cabecalho) {
    $sheet->setCellValue($coluna . '1', $cabecalho);
    $coluna++;
}

// Dados
$linha = 2;
while ($q = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $linha, $q['nome']);
    $sheet->setCellValue('B' . $linha, $q['email']);
    $sheet->setCellValue('C' . $linha, $q['funcao']);
    $sheet->setCellValue('D' . $linha, $q['cpf']);
    $sheet->setCellValue('E' . $linha, $q['telefone']);
    $sheet->setCellValue('F' . $linha, calcularIdade($q['data_nascimento']) . ' anos');
    $sheet->setCellValue('G' . $linha, tempoDesde($q['data_cadastro']));
    $sheet->setCellValue('H' . $linha, $q['endereco']);
    $sheet->setCellValue('I' . $linha, $q['ativo']);
    $linha++;
}

// Estilização básica (opcional)
$sheet->getStyle('A1:I1')->getFont()->setBold(true);
$sheet->getStyle('A1:I1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FF010440');
$sheet->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);

// Cabeçalhos de download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="usuarios.xlsx"');
header('Cache-Control: max-age=0');

// Salva a planilha para o navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
