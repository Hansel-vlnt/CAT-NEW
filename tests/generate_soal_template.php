<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Template Import Soal');

// Headers
$headers = [
    'A1' => ['title' => 'ID Soal', 'width' => 12, 'comment' => "ID Paket Soal (Contoh: 84).\nBoleh dikosongkan jika mengunggah langsung dari halaman detail paket soal."],
    'B1' => ['title' => 'Soal', 'width' => 45, 'comment' => "Teks butir pertanyaan soal yang akan ditampilkan ke siswa."],
    'C1' => ['title' => 'Pilihan A', 'width' => 25, 'comment' => "Teks opsi jawaban A."],
    'D1' => ['title' => 'Pilihan B', 'width' => 25, 'comment' => "Teks opsi jawaban B."],
    'E1' => ['title' => 'Pilihan C', 'width' => 25, 'comment' => "Teks opsi jawaban C."],
    'F1' => ['title' => 'Pilihan D', 'width' => 25, 'comment' => "Teks opsi jawaban D."],
    'G1' => ['title' => 'Pilihan E', 'width' => 25, 'comment' => "Teks opsi jawaban E."],
    'H1' => ['title' => 'Tipe Soal', 'width' => 16, 'comment' => "Tipe butir soal:\n- 'single' : 1 kunci jawaban (Pilihan Ganda Tunggal)\n- 'multi'  : > 1 kunci jawaban (Pilihan Ganda Majemuk)\nJika dikosongkan, otomatis dianggap 'single'."],
    'I1' => ['title' => 'Kunci Jawaban', 'width' => 18, 'comment' => "Kunci jawaban benar:\n- Untuk single: Tulis 1 huruf kapital (contoh: A atau B)\n- Untuk multi : Tulis huruf dipisah koma (contoh: A,C atau A,B,D)"],
    'J1' => ['title' => 'Score', 'width' => 12, 'comment' => "Bobot skor nilai jika siswa menjawab benar (contoh: 5). Default: 5."],
    'K1' => ['title' => 'Trik Cepat', 'width' => 35, 'comment' => "Trik cepat / jalan pintas / cara praktis pengerjaan soal (Opsional)."],
    'L1' => ['title' => 'Pembahasan Konseptual', 'width' => 45, 'comment' => "Penjelasan konsep materi dan teori pembahasan lengkap (Opsional)."]
];

foreach ($headers as $cell => $info) {
    $sheet->setCellValue($cell, $info['title']);
    $col = substr($cell, 0, 1);
    $sheet->getColumnDimension($col)->setWidth($info['width']);
    
    // Add comment
    $comment = $sheet->getComment($cell);
    $comment->getText()->createTextRun($info['comment']);
    $comment->setWidth('250pt');
    $comment->setHeight('80pt');
}

// Sample Rows
$sampleData = [
    [
        'ID Soal' => '',
        'Soal' => 'Berapakah hasil perhitungan dari 15 x 12?',
        'Pilihan A' => '150',
        'Pilihan B' => '180',
        'Pilihan C' => '190',
        'Pilihan D' => '200',
        'Pilihan E' => '210',
        'Tipe Soal' => 'single',
        'Kunci Jawaban' => 'B',
        'Score' => 5,
        'Trik Cepat' => 'Gunakan metode distributif: 15 x (10 + 2) = 150 + 30 = 180.',
        'Pembahasan Konseptual' => 'Perkalian dua digit dapat dipecah menjadi penjumlahan kelipatan puluhan dan satuan untuk mempercepat kalkulasi tanpa rumus rumit.'
    ],
    [
        'ID Soal' => '',
        'Soal' => 'Manakah dari materi berikut yang diujikan dalam Seleksi Kompetensi Dasar (SKD) Kedinasan/CPNS? (Pilih lebih dari satu)',
        'Pilihan A' => 'Tes Wawasan Kebangsaan (TWK)',
        'Pilihan B' => 'Tes Karakteristik Pribadi (TKP)',
        'Pilihan C' => 'Tes Intelegensia Umum (TIU)',
        'Pilihan D' => 'Tes Psikotes Klinis',
        'Pilihan E' => 'Tes Kesamaptaan Jasmani',
        'Tipe Soal' => 'multi',
        'Kunci Jawaban' => 'A,B,C',
        'Score' => 5,
        'Trik Cepat' => 'SKD Kedinasan selalu terdiri dari 3 subtes inti: TWK, TKP, dan TIU.',
        'Pembahasan Konseptual' => 'Sesuai dengan ketentuan KemenPAN-RB dan BKN, tahapan ujian SKD terstandarisasi terdiri dari 3 kategori: TWK (nasionalisme & pilar negara), TIU (kemampuan verbal, numerik, dan logis), serta TKP (orientasi pelayanan dan integritas).'
    ]
];

$rowNum = 2;
foreach ($sampleData as $row) {
    $colIndex = 1;
    foreach ($row as $val) {
        $sheet->setCellValueByColumnAndRow($colIndex, $rowNum, $val);
        $colIndex++;
    }
    $rowNum++;
}

// Styling Header
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 11,
        'name' => 'Calibri'
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '0F766E'] // Elegant dark emerald
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '0D5E57']
        ]
    ]
];
$sheet->getStyle('A1:L1')->applyFromArray($headerStyle);
$sheet->getRowDimension(1)->setRowHeight(32);

// Styling Data Rows
$dataStyle = [
    'font' => [
        'size' => 10,
        'name' => 'Calibri'
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_TOP,
        'wrapText' => true
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'E2E8F0']
        ]
    ]
];
$sheet->getStyle('A2:L3')->applyFromArray($dataStyle);

// Center alignment for specific columns (ID Soal, Tipe Soal, Kunci, Score)
$sheet->getStyle('A2:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('H2:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Save XLSX
$xlsxWriter = new Xlsx($spreadsheet);
$xlsxPath = 'public/file/soal.xlsx';
$xlsxWriter->save($xlsxPath);
echo "Saved: " . $xlsxPath . "\n";

// Save XLS for legacy compatibility
$xlsWriter = new Xls($spreadsheet);
$xlsPath = 'public/file/soal.xls';
$xlsWriter->save($xlsPath);
echo "Saved: " . $xlsPath . "\n";
