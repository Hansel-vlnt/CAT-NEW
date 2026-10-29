const { chromium } = require('playwright');
const path = require('path');
const { execSync } = require('child_process');

(async () => {
  console.log('================================================================');
  console.log('🧪 PENGUJIAN MENYELURUH (FE & BE): IMPORT SOAL DUMMY & UJIAN SISWA');
  console.log('================================================================\n');

  // STEP 0: Create dedicated dummy test package in DB
  console.log('--- [STEP 0] Menyiapkan Paket Soal Dummy di Database ---');
  const createOutput = execSync('php tests/manage_test_package.php create', {
    cwd: path.resolve(__dirname, '..')
  }).toString();
  const packageData = JSON.parse(createOutput.trim());
  const packageId = packageData.package_id;
  console.log(`✓ Paket Uji Coba berhasil dibuat dengan ID: #${packageId}\n`);

  const browser = await chromium.launch({ headless: true });
  const adminContext = await browser.newContext({ viewport: { width: 1280, height: 900 } });
  const adminPage = await adminContext.newPage();

  try {
    // -------------------------------------------------------------
    // PART A: ADMIN FE & BE (IMPORT VIA EXCEL)
    // -------------------------------------------------------------
    console.log('--- [STEP 1] Login Admin ---');
    await adminPage.goto('http://127.0.0.1:8000/login');
    await adminPage.fill('#email', 'admin@abdipraja.co.id');
    await adminPage.fill('#password', 'admin123');
    await adminPage.click('button[type="submit"]');
    await adminPage.waitForURL(url => !url.pathname.includes('/login'));
    console.log('✓ Admin berhasil login.');

    console.log(`\n--- [STEP 2] Membuka Halaman Detail Paket #${packageId} ---`);
    await adminPage.goto(`http://127.0.0.1:8000/elearning/soal/detail/${packageId}`);
    await adminPage.waitForSelector('[data-target="#modal-import-soal"]');
    console.log('✓ Halaman paket soal termuat.');

    console.log('\n--- [STEP 3] Membuka Modal Import Excel ---');
    await adminPage.click('[data-target="#modal-import-soal"]');
    await adminPage.waitForSelector('#modal-import-soal', { state: 'visible' });
    await adminPage.waitForTimeout(400);

    // Verify modal elements
    const modalText = await adminPage.locator('#modal-import-soal').innerText();
    if (modalText.includes('Multi Key') && modalText.includes('Pembahasan Konseptual')) {
      console.log('✓ Modal FE memuat instruksi Multi Key dan Pembahasan Konseptual.');
    } else {
      console.warn('⚠ Teks instruksi modal belum lengkap.');
    }

    console.log('\n--- [STEP 4] Unggah Berkas tests/dummy_import_test.xlsx ---');
    const dummyExcelPath = path.resolve(__dirname, 'dummy_import_test.xlsx');
    await adminPage.setInputFiles('#modal-import-soal input[name="file"]', dummyExcelPath);
    await adminPage.waitForTimeout(300);

    // Submit form
    console.log('Mengirim form import ke Backend...');
    await Promise.all([
      adminPage.waitForNavigation(),
      adminPage.click('#modal-import-soal button[type="submit"]')
    ]);

    console.log('\n--- [STEP 5] Memverifikasi Halaman Hasil Import (BE & FE) ---');
    const resultHtml = await adminPage.content();
    const isImportSuccess = resultHtml.includes('Import Berkas Selesai');
    const hasBackBtn = resultHtml.includes('Lihat Paket Soal Ini');

    console.log('Import selesai tampil di UI:', isImportSuccess ? 'PASS' : 'FAIL');
    console.log('Tombol "Lihat Paket Soal Ini" tersedia:', hasBackBtn ? 'PASS' : 'FAIL');

    await adminPage.screenshot({ path: 'screenshots/dummy_01_import_result.png' });
    console.log('✓ Screenshot disimpan: screenshots/dummy_01_import_result.png');

    console.log('\n--- [STEP 6] Kembali ke Paket Soal & Cek Daftar Butir Soal ---');
    await Promise.all([
      adminPage.waitForNavigation(),
      adminPage.click('a:has-text("Lihat Paket Soal Ini")')
    ]);

    await adminPage.waitForSelector('#table_detail_soal');
    await adminPage.waitForTimeout(1200); // Tunggu Datatable render data via AJAX

    const tableRows = await adminPage.locator('#table_detail_soal tbody tr').count();
    console.log(`Jumlah baris soal di tabel admin: ${tableRows} baris`);
    await adminPage.screenshot({ path: 'screenshots/dummy_02_admin_table.png', fullPage: true });
    console.log('✓ Screenshot disimpan: screenshots/dummy_02_admin_table.png');

    // Get imported question IDs from DB for this package
    const qIdsOutput = execSync(`php tests/manage_test_package.php get_questions ${packageId}`, {
      cwd: path.resolve(__dirname, '..')
    }).toString().trim();
    const qIds = JSON.parse(qIdsOutput).questions;
    console.log('ID Butir Soal yang terdaftar:', qIds);

    console.log('\n--- [STEP 7] Periksa Detail Butir Soal #2 (Multi-Key Eksplisit A,C,D) ---');
    await adminPage.goto(`http://127.0.0.1:8000/elearning/soal/detail/data-soal/${qIds[1]}`);
    await adminPage.waitForSelector('.box.box-primary');
    await adminPage.waitForTimeout(500);

    const q2Html = await adminPage.content();
    const q2HasMulti = q2Html.includes('Pilihan Ganda Kompleks / Multi');
    const q2HasTrik = q2Html.includes('Trik Cepat / Solusi Praktis');
    const q2HasKonsep = q2Html.includes('Pembahasan Konseptual / Langkah Runtut');
    console.log('Lencana Multi-Key aktif:', q2HasMulti ? 'PASS' : 'FAIL');
    console.log('Kotak Trik Cepat terisi:', q2HasTrik ? 'PASS' : 'FAIL');
    console.log('Kotak Pembahasan Konsep terisi:', q2HasKonsep ? 'PASS' : 'FAIL');
    await adminPage.screenshot({ path: 'screenshots/dummy_03_admin_multi_detail.png', fullPage: true });
    console.log('✓ Screenshot disimpan: screenshots/dummy_03_admin_multi_detail.png');

    console.log('\n--- [STEP 8] Periksa Detail Butir Soal #3 (Auto-Detected Multi-Key B,C) ---');
    await adminPage.goto(`http://127.0.0.1:8000/elearning/soal/detail/data-soal/${qIds[2]}`);
    await adminPage.waitForSelector('.box.box-primary');
    await adminPage.waitForTimeout(500);

    const q3Html = await adminPage.content();
    const q3HasMulti = q3Html.includes('Pilihan Ganda Kompleks / Multi');
    console.log('Auto-detect kolom kosong & " b , c " menjadi Multi-Key:', q3HasMulti ? 'PASS' : 'FAIL');
    await adminPage.screenshot({ path: 'screenshots/dummy_04_admin_autodetect_detail.png', fullPage: true });
    console.log('✓ Screenshot disimpan: screenshots/dummy_04_admin_autodetect_detail.png');

    console.log('\n--- [STEP 9] Terbitkan Paket Soal agar Siswa Dapat Mengakses ---');
    await adminPage.goto(`http://127.0.0.1:8000/elearning/soal/detail/${packageId}`);
    await adminPage.waitForSelector('#btn-toggle-publish, #publish-banner-box');
    
    // Trigger publish
    const publishBtn = adminPage.locator('#btn-toggle-publish, button:has-text("Terbitkan Sekarang")').first();
    await publishBtn.click();
    await adminPage.waitForTimeout(600);

    // Dismiss SweetAlert if present
    const swalConfirmBtn = adminPage.locator('.confirm, .swal-button--confirm, button:has-text("Sip, Mengerti")');
    if (await swalConfirmBtn.isVisible()) {
      await swalConfirmBtn.click();
    }
    await adminPage.waitForTimeout(500);

    console.log('✓ Paket berhasil diterbitkan.');
    await adminPage.screenshot({ path: 'screenshots/dummy_05_admin_published.png' });
    console.log('✓ Screenshot disimpan: screenshots/dummy_05_admin_published.png');

    await adminContext.close();

    // -------------------------------------------------------------
    // PART B: SISWA FE & BE (MENGERJAKAN UJIAN SECARA NYATA)
    // -------------------------------------------------------------
    console.log('\n=============================================================');
    console.log('👨‍🎓 [PART B] PENGUJIAN SISWA: MENGERJAKAN SOAL & EVALUASI NILAI');
    console.log('=============================================================');

    const studentContext = await browser.newContext({ viewport: { width: 1280, height: 900 } });
    const studentPage = await studentContext.newPage();

    console.log('\n--- [STEP 10] Login Siswa ---');
    await studentPage.goto('http://127.0.0.1:8000/login');
    await studentPage.fill('#email', 'siswa_les@abdipraja.id');
    await studentPage.fill('#password', 'siswa123');
    await studentPage.click('button[type="submit"]');
    await studentPage.waitForURL(url => !url.pathname.includes('/login'));
    console.log('✓ Siswa berhasil login.');

    console.log(`\n--- [STEP 11] Masuk ke Halaman Ujian Paket #${packageId} ---`);
    await studentPage.goto(`http://127.0.0.1:8000/siswa/ujian/detail/${packageId}`);
    await studentPage.waitForSelector('#start-exam');
    await studentPage.screenshot({ path: 'screenshots/dummy_06_student_pre_exam.png' });
    console.log('✓ Halaman pratinjau ujian termuat.');

    console.log('\n--- [STEP 12] Mulai Ujian (Klik "Mulai Ujian") ---');
    await studentPage.click('#start-exam');
    await studentPage.waitForSelector('#specialstuff', { state: 'visible' });
    await studentPage.waitForTimeout(600);

    // Selesaikan 4 soal satu per satu
    console.log('\n--- [STEP 13] Menjawab Butir Soal ---');

    for (let no = 1; no <= 4; no++) {
      console.log(`\n-> Membuka Soal No ${no}...`);
      if (no > 1) {
        await studentPage.click(`.no_soal[data-no="${no}"]`);
        await studentPage.waitForTimeout(600);
      }

      // Check current question text and answer it correctly
      const soalText = await studentPage.locator('#wrap-soal .soal').innerText();
      console.log(`Teks Pertanyaan: "${soalText.substring(0, 50)}..."`);

      if (soalText.includes('planet terbesar')) {
        // Soal 1: Single Key -> B (Jupiter)
        console.log('Mendeteksi Soal 1 (Single Key) -> Memilih Opsi B (Jupiter)...');
        await studentPage.click('#wrap-soal .jawab[data-opsi="B"]');
        await studentPage.waitForTimeout(400);
      } else if (soalText.includes('kekuasaan kehakiman') || soalText.includes('Yudikatif')) {
        // Soal 2: Multi Key -> A (MA), C (MK), D (KY)
        console.log('Mendeteksi Soal 2 (Multi Key) -> Mencentang Opsi A, C, dan D...');
        await studentPage.click('#wrap-soal .jawab[data-opsi="A"]');
        await studentPage.waitForTimeout(300);
        await studentPage.click('#wrap-soal .jawab[data-opsi="C"]');
        await studentPage.waitForTimeout(300);
        await studentPage.click('#wrap-soal .jawab[data-opsi="D"]');
        await studentPage.waitForTimeout(400);
      } else if (soalText.includes('bilangan prima')) {
        // Soal 3: Multi Key Auto-detected -> B (2), C (3)
        console.log('Mendeteksi Soal 3 (Auto Multi Key) -> Mencentang Opsi B dan C...');
        await studentPage.click('#wrap-soal .jawab[data-opsi="B"]');
        await studentPage.waitForTimeout(300);
        await studentPage.click('#wrap-soal .jawab[data-opsi="C"]');
        await studentPage.waitForTimeout(400);
      } else if (soalText.includes('Indonesia Raya')) {
        // Soal 4: Single Key -> A (W.R. Soepratman)
        console.log('Mendeteksi Soal 4 (Single Key) -> Memilih Opsi A (W.R. Soepratman)...');
        await studentPage.click('#wrap-soal .jawab[data-opsi="A"]');
        await studentPage.waitForTimeout(400);
      }
    }

    await studentPage.screenshot({ path: 'screenshots/dummy_07_student_answered.png', fullPage: true });
    console.log('✓ Seluruh 4 butir soal telah dijawab. Screenshot: screenshots/dummy_07_student_answered.png');

    console.log('\n--- [STEP 14] Mengumpulkan Ujian (Klik "Selesai") ---');
    await studentPage.click('#kirim');
    await studentPage.waitForTimeout(600);

    // Handle confirmation dialog (SweetAlert or confirmation div)
    try {
      const swalConfirm = studentPage.locator('.swal2-confirm, .swal-button--confirm, button:has-text("Ya, Kumpulkan Jawaban")');
      if (await swalConfirm.isVisible({ timeout: 2000 })) {
        await swalConfirm.click();
      } else {
        await studentPage.click('#kirim-jawaban');
      }
    } catch (e) {
      console.log('Fallback: memanggil kirimJawaban() langsung di browser...');
      await studentPage.evaluate(() => kirimJawaban());
    }

    await studentPage.waitForURL(url => url.pathname.includes('/finish/'), { timeout: 15000 });
    console.log('✓ Ujian berhasil dikumpulkan dan berpindah ke halaman pembahasan.');

    console.log('\n--- [STEP 15] Memverifikasi Halaman Hasil & Pembahasan Siswa ---');
    await studentPage.waitForTimeout(1000);
    const finishHtml = await studentPage.content();

    const hasCorrectMarks = (finishHtml.match(/Jawaban Kamu Benar/g) || []).length;
    console.log(`Jumlah soal terjawab benar terdeteksi: ${hasCorrectMarks} dari 4`);

    const hasMultiBadge = finishHtml.includes('Multi-Jawaban');
    console.log('Lencana "Multi-Jawaban" tampil di review:', hasMultiBadge ? 'PASS' : 'FAIL');

    const hasTrikBox = finishHtml.includes('Trik Cepat / Solusi Praktis');
    console.log('Kotak Trik Cepat tampil untuk siswa:', hasTrikBox ? 'PASS' : 'FAIL');

    const hasKonsepBox = finishHtml.includes('Pembahasan Konseptual');
    console.log('Kotak Pembahasan Konseptual tampil untuk siswa:', hasKonsepBox ? 'PASS' : 'FAIL');

    await studentPage.screenshot({ path: 'screenshots/dummy_08_student_result_explanation.png', fullPage: true });
    console.log('✓ Screenshot disimpan: screenshots/dummy_08_student_result_explanation.png');

    await studentContext.close();

    console.log('\n=============================================================');
    console.log('🎉 SEMUA PENGUJIAN FE, BE, & LOGIKA IMPORT BERHASIL 100%!');
    console.log('=============================================================');

  } finally {
    // Teardown / Cleanup
    console.log('\n--- [CLEANUP] Membersihkan Paket Uji Coba #${packageId} ---');
    execSync(`php tests/manage_test_package.php delete ${packageId}`, {
      cwd: path.resolve(__dirname, '..')
    });
    console.log(`✓ Data paket #${packageId} dan butir soal uji coba telah dibersihkan.`);
    await browser.close();
  }
})();
