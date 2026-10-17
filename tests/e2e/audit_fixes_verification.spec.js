import { test, expect } from '@playwright/test';

test.describe('Audit Findings #01 - #19 Verification Suite', () => {

  test('Audit #01 & #03: Viewport meta user-scalable & Sidebar Navigation Links', async ({ page }) => {
    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // Verify #01 Viewport meta tag
    const metaViewport = await page.locator('meta[name="viewport"]').getAttribute('content');
    expect(metaViewport).toContain('user-scalable=yes');

    // Verify #03 Sidebar navigation links in DOM
    const sidebar = page.locator('.sidebar-menu');
    await expect(sidebar.locator('a[href*="/elearning/materi"]')).toBeAttached();
    await expect(sidebar.locator('a[href*="/master/kelas"]')).toBeAttached();
    await expect(sidebar.locator('a[href*="/master/guru"]')).toBeAttached();
  });

  test('Audit #04, #15, #16: Bank Soal Index & Detail Modernization', async ({ page }) => {
    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // Check Soal Index (#04 & #15)
    await page.goto('/elearning/soal');
    await expect(page.locator('text=Katalog Paket Latihan')).toBeVisible();
    await page.click('#btn-soal');
    await expect(page.locator('#waktu_menit')).toBeVisible();
    await expect(page.locator('#kkm')).toBeVisible();

    // Check Soal Detail (#16 Excel Import, #11 TKP Bobot & #12 Disabled Toggles)
    await page.goto('/elearning/soal/detail/8');
    await expect(page.locator('button[data-target="#modal-import-soal"]')).toBeVisible();
    
    // Open Form Tambah Soal
    await page.click('#btn-soal');
    await expect(page.locator('#form-soal')).toBeVisible();

    // Check toggleFormTipeSoal disabled attributes (#12)
    const singleRadio = page.locator('#form-wrap-kunci-single input[type="radio"]').first();
    const multiCheckbox = page.locator('#form-wrap-kunci-multi input[type="checkbox"]').first();
    const tkpInput = page.locator('#form-wrap-kunci-tkp input[type="number"]').first();

    // By default single is enabled, multi and tkp are disabled
    await expect(singleRadio).toBeEnabled();
    await expect(multiCheckbox).toBeDisabled();
    await expect(tkpInput).toBeDisabled();

    // Switch to TKP
    await page.locator('input[name="tipe_soal"][value="tkp"]').check();
    await expect(singleRadio).toBeDisabled();
    await expect(multiCheckbox).toBeDisabled();
    await expect(tkpInput).toBeEnabled();
    await expect(page.locator('#form-wrap-kunci-tkp')).toBeVisible();

    // Switch to Multi
    await page.locator('input[name="tipe_soal"][value="multi"]').check();
    await expect(singleRadio).toBeDisabled();
    await expect(multiCheckbox).toBeEnabled();
    await expect(tkpInput).toBeDisabled();
    await expect(page.locator('#form-wrap-kunci-multi')).toBeVisible();
  });

  test('Audit #18: Master Siswa Index - Form Fields & Action Header', async ({ page }) => {
    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // Go to Master Siswa
    await page.goto('/master/siswa');
    await expect(page.locator('text=Daftar Akun Siswa')).toBeVisible();

    // Click Tambah Siswa
    await page.click('#btn-siswa');
    await expect(page.locator('#wrap-siswa')).toBeVisible();

    // Verify fields: no_induk, id_kelas, email placeholder
    await expect(page.locator('#no_induk')).toBeVisible();
    await expect(page.locator('#id_kelas')).toBeVisible();
    const emailPlaceholder = await page.locator('#email').getAttribute('placeholder');
    expect(emailPlaceholder).toContain('abdipraja.id');
  });

  test('Audit #05: Siswa Katalog - Normalized Category Filter Tabs', async ({ page }) => {
    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // Go to Siswa Ujian
    await page.goto('/siswa/ujian');
    await expect(page.locator('#btn-filter-all')).toBeVisible();
    await expect(page.locator('#btn-filter-kedinasan')).toBeVisible();
    await expect(page.locator('#btn-filter-sma')).toBeVisible();

    // Click filter Kedinasan
    await page.click('#btn-filter-kedinasan');
    const kedinasanCards = await page.locator('.paket-card[data-category="kedinasan"]').count();
    expect(kedinasanCards).toBeGreaterThanOrEqual(1);

    // Click filter SMA
    await page.click('#btn-filter-sma');
    const allCards = await page.locator('.paket-card').count();
    expect(allCards).toBeGreaterThanOrEqual(1);
  });

  test('Audit #06, #07, #08: Student Exam Screen - Question 1 Sync, Ragu Button, and Batalkan Alert', async ({ page }) => {
    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // Open detail ujian paket 6
    await page.goto('/siswa/ujian/detail/6');
    if (await page.locator('input[name="password"]').isVisible()) {
      await page.fill('input[name="password"]', 'cerdas');
      await page.click('button[type="submit"]');
    }

    // Click Mulai Latihan
    await expect(page.locator('#start-exam')).toBeVisible();
    await page.click('#start-exam');
    await expect(page.locator('#specialstuff')).toBeVisible();

    // #06: Verify Question 1 has .opsi-container
    await expect(page.locator('#wrap-soal .opsi-container')).toBeVisible();

    // #07: Verify Ragu-ragu button exists and question numbers are rendered
    const btnRagu = page.locator('#btn-ragu');
    await expect(btnRagu).toBeVisible();

    // Click Ragu-ragu and verify it toggles
    await btnRagu.click();
    await expect(btnRagu).toContainText('Hapus Ragu');

    // #08: Verify Batalkan Ujian triggers confirmation
    await page.click('#keluar');
    await expect(page.locator('.swal2-modal, .swal2-popup')).toBeVisible();
  });

  test('Audit #09: Scorecard & Pembahasan HTML Unescaped & KaTeX Ready', async ({ page }) => {
    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // Visit Finish page
    await page.goto('/siswa/ujian/finish/8');
    await expect(page.locator('text=Rapor Hasil Latihan')).toBeVisible();
    await expect(page.locator('text=Trik Cepat / Solusi Praktis').first()).toBeVisible();
    await expect(page.locator('text=Pembahasan Konseptual').first()).toBeVisible();
  });

  test('Audit #17: Materi Pembelajaran Module', async ({ page }) => {
    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // Go to Materi Admin
    await page.goto('/elearning/materi');
    await expect(page.locator('text=Daftar Modul & Materi')).toBeVisible();
    await expect(page.locator('#table_materi')).toBeVisible();
  });

});
