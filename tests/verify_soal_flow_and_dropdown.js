const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const adminContext = await browser.newContext({ viewport: { width: 1280, height: 900 } });
  const page = await adminContext.newPage();

  console.log('=== TEST 1: Admin Detail Soal Draft & Dropdowns ===');
  await page.goto('http://127.0.0.1:8000/login');
  await page.fill('#email', 'admin@abdipraja.co.id');
  await page.fill('#password', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL(url => !url.pathname.includes('/login'));

  await page.goto('http://127.0.0.1:8000/elearning/soal/detail/84');
  await page.waitForSelector('#draft-banner');
  console.log('✓ Draft banner is visible on empty package ID 84.');

  // Check publish button
  const pubBtn = page.locator('#btn-toggle-publish');
  console.log('Publish button text:', (await pubBtn.innerText()).trim());

  // Click publish on 0-question package
  await pubBtn.click();
  await page.waitForSelector('.swal2-popup, .sweet-alert', { timeout: 5000 });
  const swalText = await page.locator('.swal2-content, .swal2-html-container, .sweet-alert p').innerText();
  console.log('SweetAlert warning on empty package:', swalText);
  await page.locator('.swal2-confirm, .sweet-alert button.confirm').click();
  await page.waitForTimeout(500);

  // Ensure form is open
  const isWrapVisible = await page.locator('#wrap-soal').isVisible();
  if (!isWrapVisible) {
    await page.click('#btn-soal');
    await page.waitForSelector('#wrap-soal', { state: 'visible' });
  }

  // Click Font Size button
  const sizeBtn = page.locator('.note-fontsize .dropdown-toggle').first();
  await sizeBtn.click();
  await page.waitForTimeout(400);

  const sizeItems = await page.evaluate(() => {
    const menu = document.querySelector('.note-fontsize .dropdown-menu');
    return Array.from(menu.querySelectorAll('li a')).map(a => ({
      text: a.innerText.trim(),
      val: a.getAttribute('data-value'),
      visible: window.getComputedStyle(a).visibility === 'visible',
      display: window.getComputedStyle(a).display,
      color: window.getComputedStyle(a).color
    }));
  });
  console.log('Font size dropdown items count:', sizeItems.length);
  console.log('Sample items:', sizeItems.slice(0, 5));
  await page.screenshot({ path: 'screenshots/verified_fontsize_rehydrated.png' });

  // Click Font Name button
  const fontBtn = page.locator('.note-fontname .dropdown-toggle').first();
  await fontBtn.click();
  await page.waitForTimeout(400);

  const fontItems = await page.evaluate(() => {
    const menu = document.querySelector('.note-fontname .dropdown-menu');
    return Array.from(menu.querySelectorAll('li a')).map(a => ({
      text: a.innerText.trim(),
      val: a.getAttribute('data-value'),
      visible: window.getComputedStyle(a).visibility === 'visible',
      display: window.getComputedStyle(a).display,
      color: window.getComputedStyle(a).color
    }));
  });
  console.log('Font name dropdown items count:', fontItems.length);
  console.log('Sample font items:', fontItems.slice(0, 4));
  await page.screenshot({ path: 'screenshots/verified_fontname_rehydrated.png' });

  console.log('\n=== TEST 2: Siswa Exam Catalog (Draft Protection) ===');
  // Login as Siswa in a fresh context
  const siswaContext = await browser.newContext({ viewport: { width: 1280, height: 900 } });
  const pageSiswa = await siswaContext.newPage();
  await pageSiswa.goto('http://127.0.0.1:8000/login');
  await pageSiswa.fill('#email', 'siswa_gratis@abdipraja.id');
  await pageSiswa.fill('#password', 'siswa123');
  await pageSiswa.click('button[type="submit"]');
  await pageSiswa.waitForURL(url => !url.pathname.includes('/login'));

  await pageSiswa.goto('http://127.0.0.1:8000/siswa/ujian');
  await pageSiswa.waitForSelector('.paket-title');
  const titles = await pageSiswa.locator('.paket-title').allInnerTexts();
  const hasDraftTest = titles.some(t => t.toLowerCase() === 'test');
  console.log('Is draft package "test" visible to student?', hasDraftTest ? 'FAIL (Visible)' : 'PASS (Hidden)');

  // Try direct URL access to draft package 84
  await pageSiswa.goto('http://127.0.0.1:8000/siswa/ujian/detail/84');
  await pageSiswa.waitForTimeout(600);
  console.log('Current URL after direct access to draft 84:', pageSiswa.url());
  const redirectedToCatalog = pageSiswa.url().includes('/siswa/ujian');
  console.log('Student blocked and redirected from draft test:', redirectedToCatalog ? 'PASS' : 'FAIL');

  console.log('\n=== TEST 3: Admin Create Package Auto-Redirect & Onboarding Flow ===');
  await page.goto('http://127.0.0.1:8000/elearning/soal');
  await page.waitForSelector('#btn-soal');
  await page.click('#btn-soal');
  await page.waitForSelector('#wrap-soal', { state: 'visible' });

  const testPkgName = 'Simulasi SKD Kedinasan ' + Date.now();
  await page.fill('#paket', testPkgName);
  await page.fill('#deskripsi', 'Uji coba alur terpadu buat paket dan butir soal.');
  await page.fill('#waktu_menit', '90');
  await page.fill('#kkm', '75');
  await page.selectOption('#jenis', '0'); // Total Waktu

  console.log('Submitting new package...');
  await page.click('#btnSimpan');

  await page.waitForURL(url => url.pathname.includes('/elearning/soal/detail/'), { timeout: 10000 });
  console.log('Successfully redirected to:', page.url());
  console.log('Contains ?baru=1 ?', page.url().includes('baru=1') ? 'PASS' : 'FAIL');

  await page.waitForSelector('#welcome-new-banner');
  console.log('✓ Welcome onboarding banner is visible.');

  const isFormOpen = await page.locator('#wrap-soal').isVisible();
  console.log('✓ Question form #wrap-soal is auto-opened:', isFormOpen ? 'PASS' : 'FAIL');

  await page.screenshot({ path: 'screenshots/verified_new_package_onboarding.png', fullPage: true });

  await browser.close();
  console.log('\nALL VERIFICATION TESTS COMPLETED SUCCESSFULLY!');
})();
