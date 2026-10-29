<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Soal;
use App\Models\Detailsoal;
use App\Models\Jawab;

$action = $argv[1] ?? 'create';

if ($action === 'create') {
    $p = new Soal();
    $p->paket = '[TEST DUMMY] Simulasi CAT SKD & Multi-Key';
    $p->deskripsi = 'Uji coba FE & BE import soal dan evaluasi jawaban';
    $p->kategori_utama = 'Kedinasan & Polri (SKD BKN/Akpol/Akmil)';
    $p->sub_kategori = 'Simulasi Mandiri';
    $p->tipe_akses = 'gratis';
    $p->harga = 0;
    $p->waktu = 3600;
    $p->jenis = 1;
    $p->jenis_soal = 0;
    $p->kkm = 70;
    $p->tampil = 0; // Starts as draft
    $p->id_user = 1;
    $p->save();

    echo json_encode(['status' => 'success', 'package_id' => $p->id]);
    exit(0);
} elseif ($action === 'delete') {
    $id = intval($argv[2] ?? 0);
    if ($id > 0) {
        Detailsoal::where('id_soal', $id)->delete();
        Jawab::where('id_soal', $id)->delete();
        Soal::where('id', $id)->delete();
        echo json_encode(['status' => 'deleted', 'package_id' => $id]);
        exit(0);
    }
} elseif ($action === 'get_questions') {
    $id = intval($argv[2] ?? 0);
    $ids = Detailsoal::where('id_soal', $id)->orderBy('id', 'ASC')->pluck('id')->toArray();
    echo json_encode(['questions' => $ids]);
    exit(0);
}
