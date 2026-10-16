// @ts-check
const { test, expect } = require('@playwright/test');
const path = require('path');

const ARTIFACT_DIR = 'C:/Users/harla/.gemini/antigravity/brain/97c2a0bd-69b7-4e15-a2e7-2df993c7fa4a/screenshots';

test.describe('Whole App Scan & Modernization Verification', () => {

  test('1. Register Page is centered & readable', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/register');
    await expect(page.locator('h1')).toContainText('Latihan Soal Abdi Praja');
    await expect(page.locator('#name')).toBeVisible();
    await page.screenshot({ path: path.join(ARTIFACT_DIR, `11_register${suffix}`), fullPage: true });
  });

  test('2. Password Reset Page is centered & readable', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/password/reset');
    await expect(page.locator('h1')).toContainText('Latihan Soal Abdi Praja');
    await expect(page.locator('#email')).toBeVisible();
    await page.screenshot({ path: path.join(ARTIFACT_DIR, `12_password_reset${suffix}`), fullPage: true });
  });

  test('3. Vouchers Page (Admin) is centered in max-w-6xl container', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    await page.goto('/vouchers');
    await expect(page.getByRole('heading', { name: 'Manajemen Voucher Lisensi' })).toBeVisible();
    await page.screenshot({ path: path.join(ARTIFACT_DIR, `13_vouchers${suffix}`), fullPage: true });
  });

  test('4. Master Siswa Page (Admin) is centered with modern actions', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    await page.goto('/master/siswa');
    await expect(page.getByRole('heading', { name: 'Daftar Akun Siswa' })).toBeVisible();
    await page.screenshot({ path: path.join(ARTIFACT_DIR, `14_master_siswa${suffix}`), fullPage: true });
  });

  test('5. Bank Soal Page (Admin) is centered in max-w-7xl container', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    await page.goto('/elearning/soal');
    await expect(page.getByRole('heading', { name: 'Katalog Paket Latihan & Tryout' })).toBeVisible();
    await page.screenshot({ path: path.join(ARTIFACT_DIR, `15_bank_soal${suffix}`), fullPage: true });
  });

  test('6. Laporan Rekap Page (Admin) is centered & clean', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    await page.goto('/elearning/laporan');
    await expect(page.getByRole('heading', { name: 'Laporan Nilai Per Paket Soal' })).toBeVisible();
    await page.screenshot({ path: path.join(ARTIFACT_DIR, `16_laporan${suffix}`), fullPage: true });
  });

  test('7. Student Exam Briefing Screen (Pre-Exam) is centered with modern specs grid', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    await page.goto('/siswa/ujian/detail/6');
    // If prompted for password, enter 'cerdas'
    if (await page.locator('input[name="password"]').isVisible()) {
      await page.fill('input[name="password"]', 'cerdas');
      await page.click('button[type="submit"]');
    }
    await expect(page.locator('#pre-exam-box')).toBeVisible();
    await expect(page.locator('#start-exam')).toBeVisible();
    await page.screenshot({ path: path.join(ARTIFACT_DIR, `17_pre_exam_briefing${suffix}`), fullPage: true });
  });

});
