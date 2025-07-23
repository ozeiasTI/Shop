<?php
session_start();
require_once("../../../db/conexao.php");
require_once("../../../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consulta 
$sql ="SELECT 
            produto.*,
            categoria.descricao AS descricao_categoria,
            fornecedor.nome AS nome_fornecedor
        FROM
            produto
        INNER JOIN categoria ON categoria.id_categoria = produto.categoria_id
        INNER JOIN fornecedor ON fornecedor.id_fornecedor = produto.fornecedor_id
        ORDER BY produto.nome ASC";

$resultado = mysqli_query($conexao, $sql);

// Cria nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Produtos');

// Cabeçalhos
$cabecalhos = ['Nome', 'Categoria', 'Preço de Custo', 'Preço de venda','Estoque total','Estoque Mínimo','Fornecedor','Ativo'];
$coluna = 'A';
foreach ($cabecalhos as $cabecalho) {
    $sheet->setCellValue($coluna . '1', $cabecalho);
    $coluna++;
}

// Dados
$linha = 2;
while ($q = mysqli_fetch_assoc($resultado)) {
    $sheet->setCellValue('A' . $linha, $q['nome']);
    $sheet->setCellValue('B' . $linha, $q['descricao_categoria']);
    $sheet->setCellValue('C' . $linha, 'R$ '.$q['preco_custo']);
    $sheet->setCellValue('D' . $linha, 'R$ '.$q['preco_venda']);
    $sheet->setCellValue('E' . $linha, $q['estoque_total']);
    $sheet->setCellValue('F' . $linha, $q['estoque_minimo']);
    $sheet->setCellValue('G' . $linha, $q['nome_fornecedor']);
    $sheet->setCellValue('H' . $linha, $q['ativo']);
    $linha++;
}

// Estilização básica (opcional)
$sheet->getStyle('A1:H1')->getFont()->setBold(true);
$sheet->getStyle('A1:H1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FF010440');
$sheet->getStyle('A1:H1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);

// Cabeçalhos de download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="produtos.xlsx"');
header('Cache-Control: max-age=0');

// Salva a planilha para o navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
