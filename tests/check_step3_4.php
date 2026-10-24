<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\Soal;
use App\Models\Materi;
use App\Models\Detailsoal;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\HomeController;

echo "=== REAL AUDIT & SECURITY RE-VERIFICATION (STEP 3 & 4) ===\n";

$freeStudent = User::where('email', 'siswa_gratis@abdipraja.id')->first();
$lesStudent = User::where('email', 'siswa_les@abdipraja.id')->first();
$soalGratis = Soal::find(8);
$soalBerbayar = Soal::where('id', '!=', 8)->first();
$materiGratis = Materi::where('tipe_akses', 'gratis')->first();
$materiBerbayar = Materi::where('tipe_akses', 'berbayar')->first();

assert($freeStudent !== null, "freeStudent must exist");
assert($lesStudent !== null, "lesStudent must exist");
assert($soalGratis !== null, "soalGratis must exist");
assert($soalBerbayar !== null, "soalBerbayar must exist");

// Reset initial state for deterministic test run
$freeStudent->status_langganan = 'gratis';
$freeStudent->tgl_berakhir_les = null;
$freeStudent->voucher = null;
$freeStudent->save();

$lesStudent->status_langganan = 'les';
$lesStudent->tgl_berakhir_les = '2026-12-31';
$lesStudent->voucher = null;
$lesStudent->save();

$siswaCtrl = new SiswaController();
$crudCtrl = new CrudController();
$homeCtrl = new HomeController();

// -------------------------------------------------------------
// AUDIT ITEM 2: Gratis Soal ID 8 has null password and directly enters exam room
// -------------------------------------------------------------
assert($soalGratis->password === null, "Soal ID 8 password must be null in database");
auth()->login($freeStudent);

$reqGratis = new Request(['id' => $soalGratis->id]);
$viewDetailGratis = $siswaCtrl->detailUjian($reqGratis);
assert($viewDetailGratis instanceof \Illuminate\View\View, "Taking gratis soal must return a View");
assert($viewDetailGratis->getName() === 'halaman-siswa.detail_ujian', "Gratis soal must return detail_ujian, NOT password_ujian!");
echo "[PASS] Audit Item 2: Siswa Gratis directly enters exam room for Soal ID 8 (halaman-siswa.detail_ujian, password bypassed)\n";

// -------------------------------------------------------------
// AUDIT ITEM 1: Security Guards on finishUjian, jawab, kirimJawaban for paid soals
// -------------------------------------------------------------
// 1. finishUjian guard on paid soal
Session::forget('error');
$resFinish = $siswaCtrl->finishUjian($soalBerbayar->id);
assert($resFinish instanceof \Illuminate\Http\RedirectResponse, "finishUjian on paid soal for free student must redirect");
assert(Session::has('error'), "finishUjian on paid soal must flash error message");
echo "[PASS] Audit Item 1a: Siswa Gratis blocked from finishUjian on Paid Soal (Redirect + Flash Error)\n";

// 2. jawab guard on paid soal
$detailPaid = Detailsoal::where('id_soal', $soalBerbayar->id)->first();
if ($detailPaid) {
    $reqJawab = new Request(['get_jawab' => 'A/' . $detailPaid->id . '/' . $freeStudent->id]);
    $resJawab = $siswaCtrl->jawab($reqJawab);
    assert($resJawab instanceof \Illuminate\Http\Response && $resJawab->getStatusCode() === 403, "jawab on paid soal must return 403");
    echo "[PASS] Audit Item 1b: Siswa Gratis blocked from jawab endpoint on Paid Soal (HTTP 403)\n";
}

// 3. kirimJawaban guard on paid soal
$reqKirim = new Request(['id_soal' => $soalBerbayar->id]);
$resKirim = $siswaCtrl->kirimJawaban($reqKirim);
assert($resKirim instanceof \Illuminate\Http\Response && $resKirim->getStatusCode() === 403, "kirimJawaban on paid soal must return 403");
echo "[PASS] Audit Item 1c: Siswa Gratis blocked from kirimJawaban endpoint on Paid Soal (HTTP 403)\n";

// 4. detailUjian guard on paid soal
$reqPaid = new Request(['id' => $soalBerbayar->id]);
$resPaid = $siswaCtrl->detailUjian($reqPaid);
assert($resPaid instanceof \Illuminate\Http\RedirectResponse, "detailUjian on paid soal must redirect for free student");
echo "[PASS] Audit Item 1d: Siswa Gratis blocked from detailUjian on Paid Soal (Redirect)\n";

// -------------------------------------------------------------
// AUDIT ITEM 3: License Status for Siswa Les at /home
// -------------------------------------------------------------
auth()->login($lesStudent);
$viewHome = $homeCtrl->index();
assert($viewHome instanceof \Illuminate\View\View, "HomeController@index must return a View");
$viewData = $viewHome->getData();
assert(isset($viewData['voucher']), "HomeController must pass voucher array to view");
assert($viewData['voucher']['status'] === 1, "Voucher status for Siswa Les must be 1 (Lisensi Aktif)");
assert($viewData['voucher']['expiry_date'] === '2026-12-31', "Voucher expiry_date must match tgl_berakhir_les (2026-12-31)");
echo "[PASS] Audit Item 3: Siswa Les license card on /home is active (status=1, expiry_date=2026-12-31)\n";

// -------------------------------------------------------------
// AUDIT ITEM 4: Case-Insensitive Voucher Activation
// -------------------------------------------------------------
auth()->login($freeStudent);

// Test 4a: Uppercase input with lowercase stored voucher
$codeLower = 'testvoucherlow' . rand(100, 999);
$vId1 = DB::table('vouchers')->insertGetId([
    'kode_voucher' => strtolower($codeLower),
    'masa_berlaku' => 30,
]);
Session::forget('success');
Session::forget('error');
$crudCtrl->aktivasi(new Request(['kode_voucher' => strtoupper($codeLower)]));
assert(Session::has('success'), "Activating uppercase string against lowercase voucher should succeed");
$updatedUser = User::find($freeStudent->id);
assert($updatedUser->status_langganan === 'les', "User must now be upgraded to les");
assert($updatedUser->isLanggananLes() === true, "User isLanggananLes() must be true");
echo "[PASS] Audit Item 4: Case-insensitive voucher activation verified (input: strtoupper vs DB: strtolower)\n";

// Cleanup voucher and revert user
DB::table('vouchers')->where('id_voucher', $vId1)->delete();
$freeStudent->status_langganan = 'gratis';
$freeStudent->tgl_berakhir_les = null;
$freeStudent->voucher = null;
$freeStudent->save();

// -------------------------------------------------------------
// AUDIT ITEM 5: Default Expiry Date on Siswa Upgrade (+1 year)
// -------------------------------------------------------------
$reqUpdate = new Request([
    'id' => $freeStudent->id,
    'status_langganan' => 'les',
    'tgl_berakhir_les' => '', // empty date
    'nama' => $freeStudent->nama,
    'email' => $freeStudent->email,
    'kelas' => '',
    'password' => '',
]);
$crudCtrl->updateSiswa($reqUpdate);
$checkUpdated = User::find($freeStudent->id);
assert($checkUpdated->status_langganan === 'les', "Student must be les");
assert(!empty($checkUpdated->tgl_berakhir_les), "Empty tgl_berakhir_les must default to +1 year");
$expectedYear = date('Y-m-d', strtotime('+1 year'));
assert($checkUpdated->tgl_berakhir_les === $expectedYear, "Expiry date must be exactly +1 year ({$expectedYear})");
assert($checkUpdated->isLanggananLes() === true, "isLanggananLes() must return true for upgraded user");
echo "[PASS] Audit Item 5a: Upgrading to les without date defaults to +1 year ({$expectedYear})\n";

// Switching back to gratis sets date to null
$reqDowngrade = new Request([
    'id' => $freeStudent->id,
    'status_langganan' => 'gratis',
    'tgl_berakhir_les' => '',
    'nama' => $freeStudent->nama,
    'email' => $freeStudent->email,
    'kelas' => '',
    'password' => '',
]);
$crudCtrl->updateSiswa($reqDowngrade);
$checkDowngraded = User::find($freeStudent->id);
assert($checkDowngraded->status_langganan === 'gratis', "Student must be gratis");
assert($checkDowngraded->tgl_berakhir_les === null, "Gratis student tgl_berakhir_les must be null");
echo "[PASS] Audit Item 5b: Downgrading to gratis sets tgl_berakhir_les to null\n";

// -------------------------------------------------------------
// AUDIT ITEM 7: Seeded Materi Verification
// -------------------------------------------------------------
$allMateri = Materi::all();
assert($allMateri->count() >= 2, "At least 2 Materi rows must exist in database");
$hasGratisMateri = Materi::where('tipe_akses', 'gratis')->exists();
$hasPaidMateri = Materi::where('tipe_akses', 'berbayar')->exists();
assert($hasGratisMateri, "Gratis materi must exist");
assert($hasPaidMateri, "Paid materi must exist");
echo "[PASS] Audit Item 7: Materi seeded successfully with both gratis and berbayar access types\n";

echo "=== ALL AUDIT CHECKS PASSED PERFECTLY ===\n";
