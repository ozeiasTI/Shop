<?php
session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consulta os usuários
$sql = "SELECT * FROM contas ";
$resultado = mysqli_query($conexao, $sql);

// Cria nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Contas');

// Cabeçalhos
$cabecalhos = ['Descrição', 'Valor', 'Tipo', 'Status', 'Data Lançamento','Data Acerto','Forma Acerto'];
$coluna = 'A';
foreach ($cabecalhos as $cabecalho) {
    $sheet->setCellValue($coluna . '1', $cabecalho);
    $coluna++;
}

// Dados
$linha = 2;
while ($q = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $linha, $q['descricao_conta']);
    $sheet->setCellValue('B' . $linha, $q['valor']);
    $sheet->setCellValue('C' . $linha, $q['tipo']);
    $sheet->setCellValue('D' . $linha, $q['status_conta']);
    $sheet->setCellValue('E' . $linha, $q['data_lancamento']);
    $sheet->setCellValue('F' . $linha, $q['data_acerto']);
    $sheet->setCellValue('G' . $linha, $q['forma_acerto']);
    $linha++;
}

// Estilização básica (opcional)
$sheet->getStyle('A1:G1')->getFont()->setBold(true);
$sheet->getStyle('A1:G1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FF010440');
$sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);

// Cabeçalhos de download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="contas.xlsx"');
header('Cache-Control: max-age=0');

// Salva a planilha para o navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
