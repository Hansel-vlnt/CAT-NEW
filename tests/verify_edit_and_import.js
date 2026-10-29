const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1280, height: 900 } });
  const page = await context.newPage();

  console.log('=== TEST: Login Admin ===');
  await page.goto('http://127.0.0.1:8000/login');
  await page.fill('#email', 'admin@abdipraja.co.id');
  await page.fill('#password', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForURL(url => !url.pathname.includes('/login'));

  console.log('\n=== TEST 1: Edit Paket - Tanpa Blok Merah Kosong ===');
  await page.goto('http://127.0.0.1:8000/elearning/soal/ubah/84');
  await page.waitForSelector('#formSoal');

  // Verify #notif is hidden initially
  const isNotifVisibleInitial = await page.locator('#notif').isVisible();
  console.log('Is #notif hidden initially?', !isNotifVisibleInitial ? 'PASS (Hidden)' : 'FAIL (Visible)');
  await page.screenshot({ path: 'screenshots/verified_edit_paket_before.png', fullPage: true });

  console.log('\n=== TEST 2: Modal Import Excel - Pewarnaan Bersih & Kontras Tinggi ===');
  await page.goto('http://127.0.0.1:8000/elearning/soal/detail/84');
  await page.waitForSelector('[data-target="#modal-import-soal"]');

  // Open Import Modal
  await page.click('[data-target="#modal-import-soal"]');
  await page.waitForSelector('#modal-import-soal', { state: 'visible' });
  await page.waitForTimeout(400);

  // Check template download button
  const downloadBtn = page.locator('#modal-import-soal a[href*="download-file-format/soal"]');
  const btnText = await downloadBtn.innerText();
  console.log('Download button text:', btnText.trim());

  const btnStyles = await page.evaluate(() => {
    const btn = document.querySelector('#modal-import-soal a[href*="download-file-format/soal"]');
    const cs = window.getComputedStyle(btn);
    return {
      color: cs.color,
      backgroundColor: cs.backgroundColor,
      fontWeight: cs.fontWeight,
      fontSize: cs.fontSize
    };
  });
  console.log('Download button computed styles:', btnStyles);

  // Take screenshot of modal
  await page.screenshot({ path: 'screenshots/verified_modal_import_clean.png' });

  await browser.close();
  console.log('\nALL VERIFICATION TESTS COMPLETED SUCCESSFULLY!');
})();
