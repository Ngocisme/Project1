<?php

require '../vendor/autoload.php';

include_once './Database.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$stmt = $conn->prepare("SELECT * FROM orders");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Order ID');
$sheet->setCellValue('B1', 'Username');
$sheet->setCellValue('C1', 'City');
$sheet->setCellValue('D1', 'District');
$sheet->setCellValue('E1', 'Ward');
$sheet->setCellValue('F1', 'Email');
$sheet->setCellValue('G1', 'Phone');
$sheet->setCellValue('H1', 'Address');
$sheet->setCellValue('I1', 'Total');
$sheet->setCellValue('J1', 'Create_at');

$row = 2;
foreach ($orders as $order) {
    $sheet->setCellValue('A' . $row, $order['id']);
    $sheet->setCellValue('B' . $row, $order['full_name']);
    $sheet->setCellValue('C' . $row, $order['city']);
    $sheet->setCellValue('D' . $row, $order['district']);
    $sheet->setCellValue('E' . $row, $order['ward']);
    $sheet->setCellValue('F' . $row, $order['email']);
    $sheet->setCellValue('G' . $row, $order['phone']);
    $sheet->setCellValue('H' . $row, $order['address']);
    $sheet->setCellValue('I' . $row, $order['totalBill']);
    $sheet->setCellValue('J' . $row, $order['created_at']);
    $row++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'orders.xlsx';

$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;