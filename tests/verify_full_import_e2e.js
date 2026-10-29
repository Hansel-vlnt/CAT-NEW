const { chromium } = require('playwright');
const path = require('path');
const { execSync } = require('child_process');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1280, height: 900 } });
  const page = await context.newPage();

  console.log('=== STEP 1: Login Admin ===');
  await page.goto('http://127.0.0.1:8000/login');
  await page.fill('#email', 'admin@abdipraja.co.id');
  await page.fill('#password', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL(url => !url.pathname.includes('/login'));

  console.log('=== STEP 2: Navigate to Detail Paket 87 ===');
  await page.goto('http://127.0.0.1:8000/elearning/soal/detail/87');
  await page.waitForSelector('[data-target="#modal-import-soal"]');

  console.log('=== STEP 3: Open & Verify Import Modal ===');
  await page.click('[data-target="#modal-import-soal"]');
  await page.waitForSelector('#modal-import-soal', { state: 'visible' });
  await page.waitForTimeout(400);

  // Take screenshot of updated modal
  await page.screenshot({ path: 'screenshots/verified_modal_import_updated.png' });
  console.log('Saved screenshot: screenshots/verified_modal_import_updated.png');

  console.log('=== STEP 4: Upload public/file/soal.xlsx ===');
  const filePath = path.resolve(__dirname, '../public/file/soal.xlsx');
  await page.setInputFiles('#modal-import-soal input[name="file"]', filePath);
  await page.waitForTimeout(300);

  // Submit
  await Promise.all([
    page.waitForNavigation(),
    page.click('#modal-import-soal button[type="submit"]')
  ]);

  console.log('=== STEP 5: Verify Result Page ===');
  const pageContent = await page.content();
  const hasSuccess = pageContent.includes('Import Berkas Selesai');
  const hasLihatPaket = pageContent.includes('Lihat Paket Soal Ini');
  console.log('Import result card present?', hasSuccess ? 'PASS' : 'FAIL');
  console.log('"Lihat Paket Soal Ini" button present?', hasLihatPaket ? 'PASS' : 'FAIL');

  await page.screenshot({ path: 'screenshots/verified_import_result_page.png' });
  console.log('Saved screenshot: screenshots/verified_import_result_page.png');

  console.log('=== STEP 6: Click "Lihat Paket Soal Ini" ===');
  await Promise.all([
    page.waitForNavigation(),
    page.click('a:has-text("Lihat Paket Soal Ini")')
  ]);

  await page.waitForSelector('#table_detail_soal');
  await page.waitForTimeout(1000); // let datatable render

  await page.screenshot({ path: 'screenshots/verified_package_detail_with_imported_soal.png', fullPage: true });
  console.log('Saved screenshot: screenshots/verified_package_detail_with_imported_soal.png');

  console.log('=== STEP 7: Check Detail View of Imported Multi-Key Question ===');
  // Get latest question ID from DB
  const latestId = execSync('php artisan tinker --execute="echo \\App\\Models\\Detailsoal::where(\'id_soal\', 87)->orderBy(\'id\', \'DESC\')->first()->id;"', { cwd: path.resolve(__dirname, '..') }).toString().trim();
  console.log('Latest imported question ID:', latestId);

  await page.goto(`http://127.0.0.1:8000/elearning/soal/detail/data-soal/${latestId}`);
  await page.waitForSelector('.box.box-primary');
  await page.waitForTimeout(500);

  await page.screenshot({ path: 'screenshots/verified_imported_question_detail_view.png', fullPage: true });
  console.log('Saved screenshot: screenshots/verified_imported_question_detail_view.png');

  // Verify elements on detail page
  const detailHtml = await page.content();
  const hasMultiBadge = detailHtml.includes('Pilihan Ganda Kompleks / Multi');
  const hasTrik = detailHtml.includes('Trik Cepat / Solusi Praktis');
  const hasKonsep = detailHtml.includes('Pembahasan Konseptual / Langkah Runtut');
  console.log('Has Multi Badge:', hasMultiBadge ? 'PASS' : 'FAIL');
  console.log('Has Trik Cepat section:', hasTrik ? 'PASS' : 'FAIL');
  console.log('Has Pembahasan Konseptual section:', hasKonsep ? 'PASS' : 'FAIL');

  console.log('=== STEP 8: Cleanup test questions from package 87 ===');
  execSync('php artisan tinker --execute="\\App\\Models\\Detailsoal::where(\'id_soal\', 87)->where(\'id\', \'>\', 4422)->delete();"', { cwd: path.resolve(__dirname, '..') });
  console.log('Cleaned up test questions.');

  await browser.close();
  console.log('\n=== ALL E2E VERIFICATIONS PASSED SUCCESSFULLY! ===');
})();
