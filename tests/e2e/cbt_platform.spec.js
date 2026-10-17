// @ts-check
const { test, expect } = require('@playwright/test');
const fs = require('fs');
const path = require('path');

test.beforeAll(async () => {
  const screenshotsDir = path.join(__dirname, '../../screenshots');
  if (!fs.existsSync(screenshotsDir)) {
    fs.mkdirSync(screenshotsDir, { recursive: true });
  }
});

test.describe('CBT Platform E2E Tests - Bank Soal & Pembahasan', () => {

  test('1. Admin Portal - Login, View Paket Soal & Dual Explanations', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Visit Login
    await page.goto('/login');
    await expect(page).toHaveTitle(/Masuk Akun|Login/);

    // 2. Fill Admin Credentials
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');

    // Wait for redirect away from login
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // 3. Navigate to Paket 8 Detail
    await page.goto('/elearning/soal/detail/8');
    await expect(page.locator('text=Detail Paket Soal').first()).toBeVisible();
    await expect(page.locator(':is(h2, h4):has-text("Latihan Kecerdasan #2")')).toBeVisible();

    await page.screenshot({ path: `screenshots/01_admin_paket_detail${suffix}`, fullPage: true });

    // 4. View Detail Question 220 (Review Soal & Dual Explanations)
    await page.goto('/elearning/soal/detail/data-soal/220');
    await expect(page.locator('text=Trik Cepat / Solusi Praktis')).toBeVisible();
    await expect(page.locator('text=Pembahasan Konseptual / Langkah Runtut')).toBeVisible();
    await expect(page.locator('text=KUNCI').first()).toBeVisible();

    await page.screenshot({ path: `screenshots/02_admin_soal_review_dual_pembahasan${suffix}`, fullPage: true });
  });

  test('2. Admin Portal - Edit Question & Dual Explanation Form', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // Go to Edit form for question 220
    await page.goto('/elearning/soal/detail/ubah/220');
    await expect(page.locator('text=Edit Butir Soal, Kunci, & Pembahasan')).toBeVisible();
    await expect(page.locator('text=Tipe Soal')).toBeVisible();
    await expect(page.locator('text=Trik Cepat / Solusi Praktis')).toBeVisible();
    await expect(page.locator('text=Pembahasan Konseptual')).toBeVisible();

    await page.screenshot({ path: `screenshots/03_admin_form_ubah_soal${suffix}`, fullPage: true });
  });

  test('3. Siswa Portal - Login, Modern Practice Catalog & Responsive Layout', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Visit Login
    await page.goto('/login');

    // 2. Fill Siswa Credentials
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // 3. Go to Siswa Ujian Catalog
    await page.goto('/siswa/ujian');
    await expect(page.locator('text=Daftar Paket Latihan Soal')).toBeVisible();
    await expect(page.locator('#search-input')).toBeVisible();
    await expect(page.locator('button:has-text("Kedinasan & Polri")')).toBeVisible();
    await expect(page.locator('button:has-text("SMA & UTBK")')).toBeVisible();

    // 4. Test Search Functionality
    await page.fill('#search-input', 'Kecerdasan');
    await expect(page.locator('#paket-counter')).toContainText('Ditemukan');
    await expect(page.locator('#btn-clear-search')).toBeVisible();

    // 5. Clear Search
    await page.click('#btn-clear-search');
    await expect(page.locator('#search-input')).toHaveValue('');
    await expect(page.locator('#paket-counter')).toContainText('Menampilkan');

    await page.screenshot({ path: `screenshots/04_siswa_katalog${suffix}`, fullPage: true });

    // 6. Search with Results & Screenshot
    await page.fill('#search-input', 'Kecerdasan');
    await expect(page.locator('.paket-card:visible').first()).toBeVisible();
    await page.screenshot({ path: `screenshots/04b_siswa_katalog_search_active${suffix}`, fullPage: true });

    // 7. Test Empty State & Reset Button
    await page.fill('#search-input', 'query_yang_pasti_tidak_ada_xyz');
    await expect(page.locator('#no-results-box')).toBeVisible();
    await page.click('button:has-text("Reset Pencarian")');
    await expect(page.locator('#no-results-box')).toBeHidden();
    await expect(page.locator('#search-input')).toHaveValue('');
  });

  test('4. Siswa Portal - Scorecard Evaluation & Dual Explanations Review', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // Visit Finish/Review page for Paket 8
    await page.goto('/siswa/ujian/finish/8');
    await expect(page.locator('text=Rapor Hasil Latihan')).toBeVisible();
    await expect(page.locator('text=Nilai Total Kamu')).toBeVisible();
    await expect(page.getByText('Benar', { exact: true }).first()).toBeVisible();
    await expect(page.getByText('Salah', { exact: true }).first()).toBeVisible();
    await expect(page.getByText('Kosong', { exact: true }).first()).toBeVisible();

    // Verify presence of Dual Explanations
    await expect(page.locator('text=Trik Cepat / Solusi Praktis').first()).toBeVisible();
    await expect(page.locator('text=Pembahasan Konseptual').first()).toBeVisible();

    await page.screenshot({ path: `screenshots/05_siswa_scorecard_pembahasan${suffix}`, fullPage: true });
  });

});
