<?php
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Template Import Soal');

$headers = [
    'A1' => 'ID Soal',
    'B1' => 'Soal',
    'C1' => 'Pilihan A',
    'D1' => 'Pilihan B',
    'E1' => 'Pilihan C',
    'F1' => 'Pilihan D',
    'E1' => 'Pilihan C',
    'F1' => 'Pilihan D',
    'G1' => 'Pilihan E',
    'H1' => 'Tipe Soal',
    'I1' => 'Kunci Jawaban',
    'J1' => 'Score',
    'K1' => 'Trik Cepat',
    'L1' => 'Pembahasan Konseptual'
];

foreach ($headers as $cell => $val) {
    $sheet->setCellValue($cell, $val);
}

// 4 Test cases
$rows = [
    [
        'ID Soal' => '', // Blank -> test fallback to active package
        'Soal' => 'Manakah planet terbesar dalam tata surya kita?',
        'Pilihan A' => 'Mars',
        'Pilihan B' => 'Jupiter',
        'Pilihan C' => 'Venus',
        'Pilihan D' => 'Merkurius',
        'Pilihan E' => 'Saturnus',
        'Tipe Soal' => 'single',
        'Kunci Jawaban' => 'B',
        'Score' => 5,
        'Trik Cepat' => 'Ingat julukan "Raksasa Gas" terbesar: Jupiter memiliki massa lebih dari dua kali lipat gabungan seluruh planet lainnya.',
        'Pembahasan Konseptual' => 'Jupiter adalah planet kelima dari Matahari dan merupakan planet terbesar dalam tata surya dengan diameter khatulistiwa sekitar 142.984 km.'
    ],
    [
        'ID Soal' => '', // Blank -> test fallback
        'Soal' => 'Pilihlah lembaga negara yang memegang kekuasaan kehakiman (Yudikatif) menurut UUD 1945! (Pilih lebih dari satu)',
        'Pilihan A' => 'Mahkamah Agung (MA)',
        'Pilihan B' => 'Dewan Perwakilan Rakyat (DPR)',
        'Pilihan C' => 'Mahkamah Konstitusi (MK)',
        'Pilihan D' => 'Komisi Yudisial (KY)',
        'Pilihan E' => 'Badan Pemeriksa Keuangan (BPK)',
        'Tipe Soal' => 'multi',
        'Kunci Jawaban' => 'A,C,D',
        'Score' => 5,
        'Trik Cepat' => 'Kekuasaan peradilan dan pengawasan hakim adalah MA, MK, dan KY. DPR adalah legislatif, BPK adalah eksaminatif.',
        'Pembahasan Konseptual' => 'Menurut UUD 1945 Bab IX, kekuasaan kehakiman dilakukan oleh Mahkamah Agung dan Mahkamah Konstitusi, sedangkan Komisi Yudisial berwenang menjaga martabat hakim.'
    ],
    [
        'ID Soal' => '', // Blank -> test fallback
        'Soal' => 'Manakah pasangan bilangan di bawah ini yang merupakan bilangan prima ganjil pertama dan prima genap satu-satunya? (Pilih dua opsi)',
        'Pilihan A' => '1',
        'Pilihan B' => '2',
        'Pilihan C' => '3',
        'Pilihan D' => '4',
        'Pilihan E' => '9',
        'Tipe Soal' => '', // BLANK -> TEST AUTO-DETECTION TO 'multi'
        'Kunci Jawaban' => ' b , c ', // LOWERCASE & SPACES -> TEST NORMALIZATION TO 'B,C'
        'Score' => 5,
        'Trik Cepat' => '2 adalah satu-satunya bilangan prima genap, dan 3 adalah prima ganjil terkecil.',
        'Pembahasan Konseptual' => 'Bilangan 2 adalah bilangan prima genap satu-satunya, sedangkan 3 adalah bilangan prima ganjil pertama. 1 bukan bilangan prima.'
    ],
    [
        'ID Soal' => '', // Will be dynamically filled or left blank
        'Soal' => 'Siapakah komponis dan pencipta lagu kebangsaan "Indonesia Raya"?',
        'Pilihan A' => 'Wage Rudolf Soepratman',
        'Pilihan B' => 'Ismail Marzuki',
        'Pilihan C' => 'Kusbini',
        'Pilihan D' => 'Cornel Simanjuntak',
        'Pilihan E' => 'Liberty Manik',
        'Tipe Soal' => 'single',
        'Kunci Jawaban' => 'a', // LOWERCASE -> TEST NORMALIZATION TO 'A'
        'Score' => 5,
        'Trik Cepat' => 'Lagu Indonesia Raya pertama kali dikumandangkan W.R. Soepratman pada Kongres Pemuda 28 Oktober 1928.',
        'Pembahasan Konseptual' => 'Wage Rudolf Soepratman adalah pahlawan nasional yang menggubah lagu kebangsaan Indonesia Raya yang diperdengarkan secara resmi pada Kongres Pemuda II.'
    ]
];

$rowIdx = 2;
foreach ($rows as $r) {
    $colIdx = 1;
    foreach ($r as $val) {
        $sheet->setCellValueByColumnAndRow($colIdx, $rowIdx, $val);
        $colIdx++;
    }
    $rowIdx++;
}

// Style header
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Calibri'],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F766E']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
];
$sheet->getStyle('A1:L1')->applyFromArray($headerStyle);
$sheet->getRowDimension(1)->setRowHeight(28);

foreach (range('A', 'L') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
$targetFile = __DIR__ . '/dummy_import_test.xlsx';
$writer->save($targetFile);
echo "Successfully generated: {$targetFile}\n";
