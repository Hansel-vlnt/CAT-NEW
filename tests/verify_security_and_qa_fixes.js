const { chromium } = require('playwright');
const path = require('path');
const assert = require('assert');

(async () => {
  console.log('================================================================');
  console.log('🛡️  VERIFIKASI PERBAIKAN KEAMANAN (SECURITY) & QA AUDIT CBT');
  console.log('================================================================\n');

  const browser = await chromium.launch({ headless: true });
  
  // -------------------------------------------------------------
  // 1. TEST SYS-01: 404 Standalone Page (Zero 500 Error)
  // -------------------------------------------------------------
  console.log('--- [TEST 1: SYS-01] Global 404 Handler ---');
  const guestPage = await browser.newPage();
  const resp404 = await guestPage.goto('http://127.0.0.1:8000/halaman-pasti-tidak-ada-998877');
  console.log(`Status HTTP: ${resp404.status()} (Expected: 404)`);
  assert.strictEqual(resp404.status(), 404, 'Status harus 404');

  const content404 = await guestPage.content();
  assert(content404.includes('Halaman Tidak Ditemukan'), 'Harus menampilkan judul 404 yang rapi');
  assert(!content404.includes('Attempt to read property "gambar" on null'), 'Tidak boleh ada error null pointer gambar');
  assert(!content404.includes('Whoops, looks like something went wrong'), 'Tidak boleh crash fatal 500');
  console.log('✓ PASS: Halaman 404 mandiri tampil aman tanpa error 500.');
  await guestPage.screenshot({ path: 'screenshots/audit_sys01_404_clean.png' });
  await guestPage.close();

  // -------------------------------------------------------------
  // 2. TEST SEC-02: Voucher Protection
  // -------------------------------------------------------------
  console.log('\n--- [TEST 2: SEC-02] Proteksi Route /vouchers ---');
  const studentContext = await browser.newContext();
  const studentPage = await studentContext.newPage();

  // Login as Siswa
  await studentPage.goto('http://127.0.0.1:8000/login');
  await studentPage.fill('#email', 'siswa_les@abdipraja.id');
  await studentPage.fill('#password', 'siswa123');
  await studentPage.click('button[type="submit"]');
  await studentPage.waitForURL(url => !url.pathname.includes('/login'));

  // Try accessing /vouchers as Siswa
  const voucherResp = await studentPage.goto('http://127.0.0.1:8000/vouchers');
  const studentUrl = studentPage.url();
  const studentPageContent = await studentPage.content();
  console.log(`Akses siswa ke /vouchers dialihkan ke: ${studentUrl}`);
  assert(!studentUrl.includes('/vouchers') || studentPageContent.includes('Akses ditolak'), 'Siswa tidak boleh mengakses halaman voucher');
  console.log('✓ PASS: Siswa dilarang membuka /vouchers.');

  // -------------------------------------------------------------
  // 3. TEST SEC-01: Mass Delete Protection
  // -------------------------------------------------------------
  console.log('\n--- [TEST 3: SEC-01] Proteksi Hapus Massal Siswa (/master/siswa/delete-all) ---');
  // Try GET request as Siswa
  const getDeleteResp = await studentPage.request.get('http://127.0.0.1:8000/master/siswa/delete-all');
  console.log(`GET /master/siswa/delete-all status: ${getDeleteResp.status()} (Expected: 405 Method Not Allowed)`);
  assert(getDeleteResp.status() === 405 || getDeleteResp.status() === 404 || getDeleteResp.status() === 403, 'GET tidak boleh diizinkan');

  // Get CSRF Token from student session
  const csrfToken = await studentPage.evaluate(() => {
    const meta = document.querySelector('meta[name="csrf-token"]') || document.querySelector('input[name="_token"]');
    return meta ? (meta.getAttribute('content') || meta.value) : '';
  });

  // Try POST request as Siswa
  const postDeleteResp = await studentPage.request.post('http://127.0.0.1:8000/master/siswa/delete-all', {
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: { password: 'wrong' }
  });
  console.log(`POST /master/siswa/delete-all as student status: ${postDeleteResp.status()} (Expected: 403)`);
  assert.strictEqual(postDeleteResp.status(), 403, 'Siswa harus ditolak saat POST delete-all');
  console.log('✓ PASS: Route delete-all dilindungi dari HTTP GET dan diblokir untuk akun non-admin.');

  // -------------------------------------------------------------
  // 4. TEST SEC-03: CRUD Role Protection & updateProfil IDOR
  // -------------------------------------------------------------
  console.log('\n--- [TEST 4: SEC-03] Proteksi Endpoint CRUD & IDOR updateProfil ---');
  // Siswa attempts to delete another student
  const deleteSiswaResp = await studentPage.request.post('http://127.0.0.1:8000/crud/delete-siswa', {
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: { id_siswa: 527 }
  });
  console.log(`POST /crud/delete-siswa as student: ${deleteSiswaResp.status()} (Expected: 403)`);
  assert.strictEqual(deleteSiswaResp.status(), 403, 'Siswa dilarang menghapus akun siswa lain');

  // Siswa attempts to save new exam package
  const simpanSoalResp = await studentPage.request.post('http://127.0.0.1:8000/crud/simpan-soal', {
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: { paket: 'Hacked', deskripsi: 'Hacked', waktu: 60, jenis: 1 }
  });
  console.log(`POST /crud/simpan-soal as student: ${simpanSoalResp.status()} (Expected: 403)`);
  assert.strictEqual(simpanSoalResp.status(), 403, 'Siswa dilarang membuat paket soal');

  // Siswa attempts IDOR updateProfil on Admin (ID 1)
  const idorResp = await studentPage.request.post('http://127.0.0.1:8000/crud/update-profil', {
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: {
      id: 1, // Attempt to target Admin
      nama: 'HACKED ADMIN',
      jk: 'L',
      email: 'hacked_admin@test.com'
    }
  });
  console.log(`POST /crud/update-profil with ID 1 executed.`);
  // Verify Admin in DB remains untouched
  const { execSync } = require('child_process');
  const adminName = execSync('php artisan tinker --execute="echo \\App\\User::find(1)->nama;"', {
    cwd: path.resolve(__dirname, '..')
  }).toString().trim();
  console.log(`Nama Admin di Database: "${adminName}"`);
  assert(!adminName.includes('HACKED'), 'Profil Admin tidak boleh dapat dimodifikasi oleh Siswa!');
  console.log('✓ PASS: IDOR dicegah, siswa hanya dapat memodifikasi profil akun sendiri.');

  // -------------------------------------------------------------
  // 5. TEST SEC-04: IDOR Cetak PDF Hasil Ujian Siswa
  // -------------------------------------------------------------
  console.log('\n--- [TEST 5: SEC-04] Proteksi IDOR Cetak PDF Laporan Siswa ---');
  // Student (703) attempts to view Student 527's PDF report
  const idorPdfResp = await studentPage.goto('http://127.0.0.1:8000/cetak/pdf/hasil-ujian-persiswa/527/8');
  console.log(`Akses PDF siswa lain status: ${idorPdfResp.status()} (Expected: 403)`);
  assert.strictEqual(idorPdfResp.status(), 403, 'Siswa dilarang mencetak rapor siswa lain');
  console.log('✓ PASS: IDOR PDF diblokir dengan kode 403 Forbidden.');

  await studentContext.close();

  // -------------------------------------------------------------
  // 6. TEST SYS-02: Export Laporan Nilai Excel via Admin
  // -------------------------------------------------------------
  console.log('\n--- [TEST 6: SYS-02] Ekspor Laporan Nilai Excel ---');
  const adminContext = await browser.newContext();
  const adminPage = await adminContext.newPage();

  await adminPage.goto('http://127.0.0.1:8000/login');
  await adminPage.fill('#email', 'admin@abdipraja.co.id');
  await adminPage.fill('#password', 'admin123');
  await adminPage.click('button[type="submit"]');
  await adminPage.waitForURL(url => !url.pathname.includes('/login'));

  // Trigger Excel export for package 8 via API request
  const excelResp = await adminPage.request.get('http://127.0.0.1:8000/elearning/laporan/excel-hasil-ujian-perkelas?soal=8');
  console.log(`Export Excel status: ${excelResp.status()} (Expected: 200)`);
  assert.strictEqual(excelResp.status(), 200, 'Export Excel harus 200 OK');

  const contentDisp = excelResp.headers()['content-disposition'] || '';
  console.log(`Content-Disposition header: ${contentDisp}`);
  assert(contentDisp.includes('.xlsx'), 'Header harus menyertakan nama file .xlsx');
  console.log('✓ PASS: Ekspor Excel Maatwebsite 3.1 berhasil 100% tanpa error 500.');

  await adminContext.close();
  await browser.close();

  console.log('\n================================================================');
  console.log('🎉 SELURUH PERBAIKAN AUDIT KEAMANAN & DEFECT TELAH TERVERIFIKASI!');
  console.log('================================================================');
})();
