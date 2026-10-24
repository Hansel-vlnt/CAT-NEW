<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\User;
use App\Models\Soal;
use App\Models\Materi;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\CrudController;

echo "=== STEP 2 VERIFICATION (ADMIN & TEACHER CRUD) ===\n";

$admin = User::where('status', 'A')->first();
auth()->login($admin);

// 1. Test SoalController@simpanSoal for create
$soalCtrl = new SoalController();
$reqCreateSoal = new Request([
    'id' => 'N',
    'paket' => 'Test Paket Step2 Automated',
    'deskripsi' => 'Testing freemium access and pricing',
    'waktu' => 3600,
    'jenis' => 0,
    'kategori_utama' => 'SMA & UTBK (SNBT)',
    'sub_kategori' => 'Kuantitatif',
    'tipe_akses' => 'berbayar',
    'harga' => 75000,
]);
$res1 = $soalCtrl->simpanSoal($reqCreateSoal);
assert($res1 === 'ok', "simpanSoal should return 'ok'");

$createdSoal = Soal::where('paket', 'Test Paket Step2 Automated')->first();
assert($createdSoal !== null, "Created soal should exist");
assert($createdSoal->tipe_akses === 'berbayar', "Created soal tipe_akses should be berbayar");
assert($createdSoal->harga == 75000, "Created soal harga should be 75000");
echo "[PASS] SoalController@simpanSoal creates paid soal with correct price\n";

// 2. Test SoalController@simpanSoal for update
$reqUpdateSoal = new Request([
    'id' => $createdSoal->id,
    'paket' => 'Test Paket Step2 Automated (Updated)',
    'deskripsi' => 'Updated to gratis',
    'waktu' => 1800,
    'jenis' => 0,
    'tipe_akses' => 'gratis',
    'harga' => 0,
]);
$res2 = $soalCtrl->simpanSoal($reqUpdateSoal);
assert($res2 === 'ok', "simpanSoal update should return 'ok'");

$updatedSoal = Soal::find($createdSoal->id);
assert($updatedSoal->tipe_akses === 'gratis', "Updated soal should now be gratis");
assert($updatedSoal->harga == 0, "Updated soal harga should be 0");
echo "[PASS] SoalController@simpanSoal updates soal to gratis\n";

// Cleanup test soal
$createdSoal->delete();

// 3. Test CrudController@simpanMateri
$crudCtrl = new CrudController();
$sesiMateri = 'test_sesi_' . time();
$reqMateri = new Request([
    'sesi' => $sesiMateri,
    'judul' => 'Test Materi Step 2',
    'isi' => 'Konten materi modul step 2',
    'status' => 'Y',
    'tipe_akses' => 'berbayar',
]);
$res3 = $crudCtrl->simpanMateri($reqMateri);
assert($res3 === 'ok', "simpanMateri should return 'ok'");

$createdMateri = Materi::where('sesi', $sesiMateri)->first();
assert($createdMateri !== null, "Created materi should exist");
assert($createdMateri->tipe_akses === 'berbayar', "Created materi should have tipe_akses = berbayar");
echo "[PASS] CrudController@simpanMateri correctly saves tipe_akses\n";

// Cleanup test materi
$createdMateri->delete();

// 4. Test CrudController@updateSiswa
$testStudent = User::where('email', 'siswa_gratis@abdipraja.id')->first();
$reqUpdateSiswa = new Request([
    'id' => $testStudent->id,
    'nama' => $testStudent->nama,
    'email' => $testStudent->email,
    'kelas' => $testStudent->id_kelas,
    'no_induk' => 'AP9999',
    'nisn' => '1234567890',
    'jk' => 'L',
    'password' => '',
    'status_langganan' => 'les',
    'tgl_berakhir_les' => '2026-11-30',
]);
$res4 = $crudCtrl->updateSiswa($reqUpdateSiswa);
assert($res4 === 'ok', "updateSiswa should return 'ok'");

$reloadedStudent = User::find($testStudent->id);
assert($reloadedStudent->status_langganan === 'les', "Student should now have status_langganan = les");
assert($reloadedStudent->tgl_berakhir_les === '2026-11-30', "Student expiry should be 2026-11-30");
assert($reloadedStudent->isLanggananLes() === true, "Student isLanggananLes() should now be true");
echo "[PASS] CrudController@updateSiswa correctly upgrades student to les\n";

// Revert test student back to gratis for subsequent steps
$reloadedStudent->status_langganan = 'gratis';
$reloadedStudent->tgl_berakhir_les = null;
$reloadedStudent->save();
echo "[PASS] Reverted test student back to gratis state\n";

echo "=== ALL STEP 2 CHECKS PASSED ===\n";
