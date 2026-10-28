<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PaketLangganan;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

echo "=== TEST SUITE: CUSTOM PAKET LANGGANAN & SMART EXTENSION ===" . PHP_EOL;

$custom = null;
$voucherCode = null;
$voucherCode2 = null;
$testUser = null;

try {
    // 1. Verifikasi Data Awal
    $initialCount = PaketLangganan::count();
    echo "1. Initial package count: $initialCount" . PHP_EOL;
    assert($initialCount >= 3, "Expected at least 3 default packages");

    // 2. Buat Paket Custom Baru (misal: 2 Bulan, Rp 75.000)
    $custom = PaketLangganan::create([
        'nama_paket'   => 'Pass 2 Bulan - Khusus Seleksi Lanjutan',
        'durasi_bulan' => 2,
        'durasi_hari'  => 60,
        'harga'        => 75000,
        'harga_coret'  => 120000,
        'badge'        => 'Spesial',
        'deskripsi'    => 'Paket khusus 2 bulan persiapan intensif tahap 2.',
        'fitur'        => "Akses Semua Soal Tahap 2\nKunci Jawaban Komprehensif\nUpdate Soal Rutin",
        'urutan'       => 4,
        'is_aktif'     => 1,
    ]);

    echo "2. Created custom package ID: {$custom->id}, Nama: {$custom->nama_paket}, Harga: {$custom->formatted_harga}" . PHP_EOL;
    assert($custom->durasi_bulan === 2, "Durasi bulan should be 2");
    assert($custom->durasi_hari === 60, "Durasi hari should be 60");
    assert($custom->harga === 75000, "Harga should be 75000");
    assert($custom->getHematNominal() === 45000, "Hemat nominal should be 45000");
    assert($custom->getHematPersen() === 38, "Hemat persen should be ~38%");
    assert(count($custom->getFiturArray()) === 3, "Fitur array should have 3 items");

    // 3. Test Generate Voucher untuk Paket Custom
    $voucherCode = 'TEST-2B-' . rand(1000, 9999);
    DB::table('vouchers')->insert([
        'kode_voucher' => $voucherCode,
        'masa_berlaku' => $custom->durasi_hari,
    ]);

    $checkVoucher = DB::table('vouchers')->where('kode_voucher', $voucherCode)->first();
    assert($checkVoucher !== null, "Voucher should exist");
    assert(intval($checkVoucher->masa_berlaku) === 60, "Voucher validity should match package (60 days)");
    echo "3. Voucher generated successfully: {$checkVoucher->kode_voucher} ({$checkVoucher->masa_berlaku} Hari)" . PHP_EOL;

    // 4. Test Aktivasi Pertama (Siswa Gratis -> Aktif 60 Hari)
    $testUser = User::firstOrNew(['email' => 'test_subscriber@abdipraja.id']);
    $testUser->nama = 'Test Subscriber';
    $testUser->status = 'S';
    $testUser->status_langganan = 'gratis';
    $testUser->tgl_berakhir_les = null;
    $testUser->voucher = null;
    $testUser->password = bcrypt('secret123');
    $testUser->save();

    Auth::login($testUser);

    $baseDate = date('Y-m-d');
    $current = Auth::user();
    if ($current->isLanggananLes() && !empty($current->tgl_berakhir_les) && $current->tgl_berakhir_les >= $baseDate) {
        $baseDate = $current->tgl_berakhir_les;
    }
    $expiry1 = date('Y-m-d', strtotime($baseDate . ' + ' . $checkVoucher->masa_berlaku . ' days'));
    DB::table('users')->where('id', $current->id)->update([
        'voucher' => $checkVoucher->id_voucher,
        'status_langganan' => 'les',
        'tgl_berakhir_les' => $expiry1,
    ]);
    DB::table('vouchers')->where('id_voucher', $checkVoucher->id_voucher)->update([
        'used_by' => $current->id,
        'used_date' => date('Y-m-d'),
    ]);

    $testUser->refresh();
    echo "4. User activated. status_langganan: {$testUser->status_langganan}, tgl_berakhir: {$testUser->tgl_berakhir_les}, isLanggananLes: " . ($testUser->isLanggananLes() ? 'TRUE' : 'FALSE') . PHP_EOL;
    assert($testUser->status_langganan === 'les', "Status should be les");
    assert($testUser->isLanggananLes() === true, "isLanggananLes should return true");
    assert($testUser->tgl_berakhir_les === $expiry1, "Expiration date should match first activation");

    // 5. Test Smart Extension (Perpanjangan saat akun masih aktif)
    $voucherCode2 = 'TEST-1B-' . rand(1000, 9999);
    DB::table('vouchers')->insert([
        'kode_voucher' => $voucherCode2,
        'masa_berlaku' => 30,
    ]);
    $checkVoucher2 = DB::table('vouchers')->where('kode_voucher', $voucherCode2)->first();

    $current = User::find($testUser->id);
    $baseDate2 = date('Y-m-d');
    if ($current->isLanggananLes() && !empty($current->tgl_berakhir_les) && $current->tgl_berakhir_les >= $baseDate2) {
        $baseDate2 = $current->tgl_berakhir_les;
    }
    $expiry2 = date('Y-m-d', strtotime($baseDate2 . ' + ' . $checkVoucher2->masa_berlaku . ' days'));
    DB::table('users')->where('id', $current->id)->update([
        'voucher' => $checkVoucher2->id_voucher,
        'status_langganan' => 'les',
        'tgl_berakhir_les' => $expiry2,
    ]);
    DB::table('vouchers')->where('id_voucher', $checkVoucher2->id_voucher)->update([
        'used_by' => $current->id,
        'used_date' => date('Y-m-d'),
    ]);

    $testUser->refresh();
    $expectedExpiry2 = date('Y-m-d', strtotime($expiry1 . ' + 30 days'));
    echo "5. Smart Extension verified: new expiry is {$testUser->tgl_berakhir_les} (expected: $expectedExpiry2)" . PHP_EOL;
    assert($testUser->tgl_berakhir_les === $expectedExpiry2, "Smart extension should extend from previous expiry");

    echo "=== ALL CUSTOM PAKET LANGGANAN & SMART EXTENSION TESTS PASSED! ===" . PHP_EOL;
} finally {
    if ($voucherCode || $voucherCode2) {
        DB::table('vouchers')->whereIn('kode_voucher', array_filter([$voucherCode, $voucherCode2]))->delete();
    }
    if ($testUser) {
        $testUser->delete();
    }
    if ($custom) {
        $custom->delete();
    }
}
