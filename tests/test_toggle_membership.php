<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\User;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;

$crud = new CrudController();

echo "=== TEST TRANSITIONS BETWEEN LES & REGULER ===\n";

// 1. Student 527 (Desi Chrisdamayanti)
$u = User::find(527);
echo "[Step 1] Initial state for ID 527:\n";
echo "  status_langganan: '{$u->status_langganan}', voucher: '{$u->voucher}', isLes: " . ($u->isLanggananLes() ? 'TRUE' : 'FALSE') . "\n";

// Set to 'gratis' (Siswa Reguler)
$reqGratis = new Request([
    'id' => 527,
    'nama' => $u->nama,
    'email' => $u->email,
    'kelas' => $u->id_kelas,
    'no_induk' => $u->no_induk,
    'nisn' => $u->nisn,
    'jk' => $u->jk,
    'status_langganan' => 'gratis',
    'tgl_berakhir_les' => '',
]);
$crud->updateSiswa($reqGratis);
$u1 = User::find(527);
echo "[Step 2] After updating to 'gratis':\n";
echo "  status_langganan: '{$u1->status_langganan}', voucher: '{$u1->voucher}', tgl_berakhir_les: '{$u1->tgl_berakhir_les}', isLes: " . ($u1->isLanggananLes() ? 'TRUE' : 'FALSE') . "\n";
assert($u1->status_langganan === 'gratis', "Status must be gratis");
assert($u1->tgl_berakhir_les === null, "tgl_berakhir_les must be null");
assert($u1->voucher === null, "voucher must be null");
assert($u1->isLanggananLes() === false, "isLanggananLes() must be FALSE for gratis student");
echo "  [PASS] Student 527 is now cleanly REGULER (isLes = FALSE)\n";

// Set back to 'les'
$reqLes = new Request([
    'id' => 527,
    'nama' => $u->nama,
    'email' => $u->email,
    'kelas' => $u->id_kelas,
    'no_induk' => $u->no_induk,
    'nisn' => $u->nisn,
    'jk' => $u->jk,
    'status_langganan' => 'les',
    'tgl_berakhir_les' => '',
]);
$crud->updateSiswa($reqLes);
$u2 = User::find(527);
echo "[Step 3] After updating to 'les':\n";
echo "  status_langganan: '{$u2->status_langganan}', tgl_berakhir_les: '{$u2->tgl_berakhir_les}', isLes: " . ($u2->isLanggananLes() ? 'TRUE' : 'FALSE') . "\n";
assert($u2->status_langganan === 'les', "Status must be les");
assert(!empty($u2->tgl_berakhir_les), "tgl_berakhir_les must be populated with default +1 year");
assert($u2->isLanggananLes() === true, "isLanggananLes() must be TRUE for les student");
echo "  [PASS] Student 527 successfully upgraded to LES (isLes = TRUE)\n";

// Set to 'reguler' (using string 'reguler' directly to test synonym handling)
$reqReguler = new Request([
    'id' => 527,
    'nama' => $u->nama,
    'email' => $u->email,
    'kelas' => $u->id_kelas,
    'no_induk' => $u->no_induk,
    'nisn' => $u->nisn,
    'jk' => $u->jk,
    'status_langganan' => 'reguler',
    'tgl_berakhir_les' => '2027-10-18', // old date passed in form
]);
$crud->updateSiswa($reqReguler);
$u3 = User::find(527);
echo "[Step 4] After updating with 'reguler' string:\n";
echo "  status_langganan: '{$u3->status_langganan}', tgl_berakhir_les: '{$u3->tgl_berakhir_les}', isLes: " . ($u3->isLanggananLes() ? 'TRUE' : 'FALSE') . "\n";
assert($u3->status_langganan === 'gratis', "Status must be normalized to gratis");
assert($u3->tgl_berakhir_les === null, "tgl_berakhir_les must be reset to null");
assert($u3->isLanggananLes() === false, "isLanggananLes() must be FALSE");
echo "  [PASS] Student 527 successfully reverted back to REGULER (isLes = FALSE)\n";

// Ensure siswa_les@abdipraja.id test account has les active
$lesAccount = User::where('email', 'siswa_les@abdipraja.id')->first();
if ($lesAccount) {
    $lesAccount->status_langganan = 'les';
    $lesAccount->tgl_berakhir_les = '2026-12-31';
    $lesAccount->save();
}

echo "=== ALL MEMBERSHIP TRANSITION TESTS PASSED ===\n";
