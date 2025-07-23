<?php
session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consulta os usuários
$sql = "SELECT * FROM fornecedor ORDER BY nome ASC ";
$resultado = mysqli_query($conexao, $sql);

// Cria nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Fornecedores');

// Cabeçalhos
$cabecalhos = ['Nome', 'CNPJ', 'Endreço', 'Ramo'];
$coluna = 'A';
foreach ($cabecalhos as $cabecalho) {
    $sheet->setCellValue($coluna . '1', $cabecalho);
    $coluna++;
}

// Dados
$linha = 2;
while ($q = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $linha, $q['nome']);
    $sheet->setCellValue('B' . $linha, $q['cnpj']);
    $sheet->setCellValue('C' . $linha, $q['endereco']);
    $sheet->setCellValue('D' . $linha, $q['ramo']);
    $linha++;
}

// Estilização básica (opcional)
$sheet->getStyle('A1:D1')->getFont()->setBold(true);
$sheet->getStyle('A1:D1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FF010440');
$sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);

// Cabeçalhos de download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="fornecedores.xlsx"');
header('Cache-Control: max-age=0');

// Salva a planilha para o navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
