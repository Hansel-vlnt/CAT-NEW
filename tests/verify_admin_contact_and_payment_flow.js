const { chromium } = require('playwright');
const assert = require('assert');

(async () => {
  console.log('================================================================');
  console.log('🧪 VERIFIKASI UPDATE KONTAK ADMIN & PEMBAYARAN TOKEN OTOMATIS');
  console.log('================================================================\n');

  const browser = await chromium.launch({ headless: true });

  // -------------------------------------------------------------
  // TEST 1: Admin Updates WhatsApp Number & Payment Info
  // -------------------------------------------------------------
  console.log('--- [TEST 1] Admin Mengubah Nomor WhatsApp & Info Bank ---');
  const adminContext = await browser.newContext();
  const adminPage = await adminContext.newPage();

  await adminPage.goto('http://127.0.0.1:8000/login');
  await adminPage.fill('#email', 'admin@abdipraja.co.id');
  await adminPage.fill('#password', 'admin123');
  await adminPage.click('button[type="submit"]');
  await adminPage.waitForURL(url => !url.pathname.includes('/login'));

  // Go to /pengaturan
  await adminPage.goto('http://127.0.0.1:8000/pengaturan');
  const csrfToken = await adminPage.evaluate(() => {
    return document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '';
  });

  const testNewWa = '0812-9988-7766';
  const updateRes = await adminPage.request.post('http://127.0.0.1:8000/pengaturan/update-kontak-pembayaran', {
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: {
      no_wa_admin: testNewWa,
      nama_bank: 'Bank BCA Digital',
      no_rekening: '9988776655',
      atas_nama_rekening: 'Abdi Praja Edukasi Resmi',
      jam_layanan: '08.00 - 22.00 WIB'
    }
  });

  console.log('Status Update Kontak Admin:', updateRes.status());
  assert.strictEqual(updateRes.status(), 200, 'Update kontak harus HTTP 200');
  const updateJson = await updateRes.json();
  console.log('Response Update:', updateJson);
  assert.strictEqual(updateJson.success, true);
  assert.strictEqual(updateJson.no_wa_sanitized, '6281299887766');
  console.log('✓ PASS: Admin berhasil memperbarui kontak WhatsApp ke', updateJson.no_wa_sanitized);

  await adminContext.close();

  // -------------------------------------------------------------
  // TEST 2: Student View Automatically Reflects New WhatsApp Number
  // -------------------------------------------------------------
  console.log('\n--- [TEST 2] Verifikasi Halaman Siswa Terupdate Otomatis ---');
  const studentContext = await browser.newContext();
  const studentPage = await studentContext.newPage();

  await studentPage.goto('http://127.0.0.1:8000/login');
  await studentPage.fill('#email', 'siswa_les@abdipraja.id');
  await studentPage.fill('#password', 'siswa123');
  await studentPage.click('button[type="submit"]');
  await studentPage.waitForURL(url => !url.pathname.includes('/login'));

  await studentPage.goto('http://127.0.0.1:8000/siswa/ujian');
  const studentContent = await studentPage.content();

  // Check if wa.me link contains 6281299887766
  assert(studentContent.includes('6281299887766'), 'Tombol WhatsApp di siswa harus terupdate dengan 6281299887766!');
  console.log('✓ PASS: Seluruh link WhatsApp siswa otomatis menggunakan nomor baru 6281299887766!');

  // -------------------------------------------------------------
  // TEST 3: Order Creation & Live Payment Detection (QRIS/Bank)
  // -------------------------------------------------------------
  console.log('\n--- [TEST 3] Pembuatan Order & Deteksi Dana Masuk (Token Muncul Otomatis) ---');
  const studentCsrf = await studentPage.evaluate(() => {
    return document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '';
  });

  // Buat pesanan pembayaran untuk paket ID 27 (Pass 1 Bulan)
  const orderRes = await studentPage.request.post('http://127.0.0.1:8000/pembayaran/buat-pesanan', {
    headers: { 'X-CSRF-TOKEN': studentCsrf },
    data: { id_paket: 27, metode: 'qris' }
  });

  console.log('Status Buat Pesanan:', orderRes.status());
  assert.strictEqual(orderRes.status(), 200);
  const orderJson = await orderRes.json();
  console.log('Order Terbentuk:', {
    order_id: orderJson.order_id,
    nama_paket: orderJson.nama_paket,
    total_bayar: orderJson.formatted_total,
    status: orderJson.status
  });
  assert(orderJson.order_id.startsWith('ORD-'), 'Order ID harus berawalan ORD-');
  assert.strictEqual(orderJson.status, 'PENDING');

  // Cek Status Awal: PENDING
  const statusAwal = await studentPage.request.get(`http://127.0.0.1:8000/pembayaran/cek-status/${orderJson.order_id}`);
  const statusAwalJson = await statusAwal.json();
  console.log('Cek Status Awal:', statusAwalJson.status);
  assert.strictEqual(statusAwalJson.status, 'PENDING');

  // Trigger Deteksi Pembayaran (Simulasi Dana Masuk / Webhook Callback)
  console.log('--> Menstimulasi deteksi dana masuk...');
  const payRes = await studentPage.request.post(`http://127.0.0.1:8000/pembayaran/simulasi-bayar/${orderJson.order_id}`, {
    headers: { 'X-CSRF-TOKEN': studentCsrf }
  });
  console.log('Status Deteksi Pembayaran:', payRes.status());
  assert.strictEqual(payRes.status(), 200);
  const payJson = await payRes.json();
  console.log('Hasil Deteksi Pembayaran:', {
    status: payJson.status,
    kode_voucher: payJson.kode_voucher,
    tgl_berakhir_les: payJson.tgl_berakhir_les
  });
  assert.strictEqual(payJson.status, 'PAID');
  assert(payJson.kode_voucher.startsWith('ABDI-'), 'Token harus berawalan ABDI-');

  // Cek Status Akhir: Polling Mendapatkan PAID dan Token Langganan
  const statusAkhir = await studentPage.request.get(`http://127.0.0.1:8000/pembayaran/cek-status/${orderJson.order_id}`);
  const statusAkhirJson = await statusAkhir.json();
  console.log('Polling Siswa Mendeteksi:', {
    status: statusAkhirJson.status,
    token: statusAkhirJson.kode_voucher
  });
  assert.strictEqual(statusAkhirJson.status, 'PAID');
  assert.strictEqual(statusAkhirJson.kode_voucher, payJson.kode_voucher);
  console.log('✓ PASS: Token langganan langsung muncul otomatis begitu dana terdeteksi masuk!');

  await studentContext.close();

  // -------------------------------------------------------------
  // TEST 4: Admin Views Transaction in /pembayaran/riwayat
  // -------------------------------------------------------------
  console.log('\n--- [TEST 4] Admin Memeriksa Riwayat Transaksi Masuk ---');
  const adminContext2 = await browser.newContext();
  const adminPage2 = await adminContext2.newPage();

  await adminPage2.goto('http://127.0.0.1:8000/login');
  await adminPage2.fill('#email', 'admin@abdipraja.co.id');
  await adminPage2.fill('#password', 'admin123');
  await adminPage2.click('button[type="submit"]');
  await adminPage2.waitForURL(url => !url.pathname.includes('/login'));

  await adminPage2.goto('http://127.0.0.1:8000/pembayaran/riwayat');
  const historyContent = await adminPage2.content();
  assert(historyContent.includes(orderJson.order_id), `Riwayat transaksi harus memuat ${orderJson.order_id}`);
  assert(historyContent.includes(payJson.kode_voucher), `Riwayat transaksi harus memuat token ${payJson.kode_voucher}`);
  console.log('✓ PASS: Admin dapat memantau transaksi dan token terbit di menu Transaksi Masuk.');

  // Reset back Admin WhatsApp to default 0857-6762-9211 for production integrity
  const adminCsrf2 = await adminPage2.evaluate(() => {
    return document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '';
  });
  await adminPage2.request.post('http://127.0.0.1:8000/pengaturan/update-kontak-pembayaran', {
    headers: { 'X-CSRF-TOKEN': adminCsrf2 },
    data: {
      no_wa_admin: '0857-6762-9211',
      nama_bank: 'Bank BCA',
      no_rekening: '8280912345',
      atas_nama_rekening: 'Abdi Praja Edukasi',
      jam_layanan: '09.00 - 21.00 WIB'
    }
  });
  console.log('✓ Kontan Admin dikembalikan ke 0857-6762-9211.');

  await adminContext2.close();
  await browser.close();

  console.log('\n================================================================');
  console.log('🎉 SEMUA PENGUJIAN FITUR UPDATE NO ADMIN & PEMBAYARAN SUKSES 100%!');
  console.log('================================================================');
})();
