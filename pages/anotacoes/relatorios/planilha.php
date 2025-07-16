<?php
session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consulta os usuários
$sql = "SELECT * FROM anotacoes ";
$resultado = mysqli_query($conexao, $sql);

// Cria nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Anotações');

// Cabeçalhos
$cabecalhos = ['Titulo', 'Mensagem', 'Categoria', 'Data', 'Status'];
$coluna = 'A';
foreach ($cabecalhos as $cabecalho) {
    $sheet->setCellValue($coluna . '1', $cabecalho);
    $coluna++;
}

// Dados
$linha = 2;
while ($q = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $linha, $q['titulo']);
    $sheet->setCellValue('B' . $linha, $q['mensagem']);
    $sheet->setCellValue('C' . $linha, $q['categoria_anotacoes']);
    $sheet->setCellValue('D' . $linha, $q['data_execucao']);
    $sheet->setCellValue('E' . $linha, $q['status_anotacoes']);
    $linha++;
}

// Estilização básica (opcional)
$sheet->getStyle('A1:E1')->getFont()->setBold(true);
$sheet->getStyle('A1:E1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FF010440');
$sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);

// Cabeçalhos de download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="anotacoes.xlsx"');
header('Cache-Control: max-age=0');

// Salva a planilha para o navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
