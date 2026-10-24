<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\User;
use App\Models\Soal;
use App\Models\Materi;

echo "=== STEP 1 VERIFICATION ===\n";

// 1. Check Soal columns and helper
$soalGratis = Soal::find(8);
assert($soalGratis !== null, "Soal ID 8 must exist");
assert($soalGratis->tipe_akses === 'gratis', "Soal ID 8 tipe_akses should be gratis");
assert($soalGratis->isGratis() === true, "Soal ID 8 isGratis() should return true");
echo "[PASS] Soal ID 8 is gratis (isGratis() === true)\n";

$soalBerbayar = Soal::where('id', '!=', 8)->first();
assert($soalBerbayar !== null, "At least one paid soal must exist");
assert($soalBerbayar->tipe_akses === 'berbayar', "Paid soal tipe_akses should be berbayar");
assert($soalBerbayar->isGratis() === false, "Paid soal isGratis() should return false");
echo "[PASS] Paid Soal ID {$soalBerbayar->id} is berbayar (isGratis() === false)\n";

// 2. Check User membership helper
$admin = User::where('status', 'A')->first();
assert($admin->isLanggananLes() === true, "Admin should always have isLanggananLes() === true");
echo "[PASS] Admin isLanggananLes() === true\n";

$freeStudent = User::where('email', 'siswa_gratis@abdipraja.id')->first();
assert($freeStudent !== null, "siswa_gratis@abdipraja.id must exist");
assert($freeStudent->isLanggananLes() === false, "Free student isLanggananLes() should return false");
echo "[PASS] Siswa Gratis isLanggananLes() === false\n";

$lesStudent = User::where('email', 'siswa_les@abdipraja.id')->first();
assert($lesStudent !== null, "siswa_les@abdipraja.id must exist");
assert($lesStudent->isLanggananLes() === true, "Tutoring student isLanggananLes() should return true");
echo "[PASS] Siswa Les isLanggananLes() === true\n";

// 3. Check Materi helper
$materi = Materi::first();
if ($materi) {
    assert(method_exists($materi, 'isGratis'), "Materi model must have isGratis() method");
    echo "[PASS] Materi ID {$materi->id} isGratis() === " . ($materi->isGratis() ? 'true' : 'false') . "\n";
}

echo "=== ALL STEP 1 CHECKS PASSED ===\n";
