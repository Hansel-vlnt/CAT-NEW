const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

async function run() {
  const browser = await chromium.launch();
  const dir = path.join(__dirname, '../screenshots');
  if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });

  // 1. Desktop Test
  {
    const context = await browser.newContext({ viewport: { width: 1280, height: 800 } });
    const page = await context.newPage();
    
    // Login
    await page.goto('http://127.0.0.1:8000/login');
    await page.fill('#email', 'siswa_gratis@abdipraja.id');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL(url => !url.pathname.includes('/login'));

    // Buka /siswa/ujian
    await page.goto('http://127.0.0.1:8000/siswa/ujian');

    // Open modal
    await page.click('button:has-text("Lihat Paket Pass")');
    await page.waitForSelector('#modal-voucher', { state: 'visible' });
    await page.waitForTimeout(600);

    // Screenshot initial modal
    await page.screenshot({ path: path.join(dir, 'modal_pass_desktop.png') });

    // Click "Bayar via QRIS / Bank" on 3 Months package (2nd card)
    const btnBayarBank = page.locator('button:has-text("Bayar via QRIS / Bank")').nth(1);
    await btnBayarBank.click();
    await page.waitForTimeout(600);

    // Screenshot with QRIS / Bank drawer expanded
    await page.screenshot({ path: path.join(dir, 'modal_pass_desktop_bank.png') });
    await context.close();
  }

  // 2. Mobile Test
  {
    const context = await browser.newContext({
      viewport: { width: 390, height: 844 },
      isMobile: true,
      hasTouch: true
    });
    const page = await context.newPage();

    // Login
    await page.goto('http://127.0.0.1:8000/login');
    await page.fill('#email', 'siswa_gratis@abdipraja.id');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL(url => !url.pathname.includes('/login'));

    // Buka /siswa/ujian
    await page.goto('http://127.0.0.1:8000/siswa/ujian');

    // Open modal
    await page.click('button:has-text("Lihat Paket Pass")');
    await page.waitForSelector('#modal-voucher', { state: 'visible' });
    await page.waitForTimeout(600);

    // Screenshot initial mobile modal
    await page.screenshot({ path: path.join(dir, 'modal_pass_mobile.png') });

    // Click "Bayar via QRIS / Bank" on 3 Months package
    const btnBayarBankMob = page.locator('button:has-text("Bayar via QRIS / Bank")').nth(1);
    await btnBayarBankMob.click();
    await page.waitForTimeout(600);

    // Screenshot mobile with QRIS / Bank drawer expanded
    await page.screenshot({ path: path.join(dir, 'modal_pass_mobile_bank.png') });
    await context.close();
  }

  await browser.close();
  console.log('Screenshots captured successfully!');
}

run().catch(console.error);
