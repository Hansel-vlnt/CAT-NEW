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

test.describe('Redesign Verification - Latihan Soal Abdi Praja UI/UX', () => {

  test('1. Login Page - Rebranding, Centered Layout & Bold Typography', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    await page.goto('/login');

    // 1. Check title & brand text
    await expect(page).toHaveTitle(/Latihan Soal Abdi Praja/);
    await expect(page.locator('h1:has-text("Latihan Soal Abdi Praja")')).toBeVisible();
    await expect(page.locator('text=Masuk ke Akun Anda')).toBeVisible();

    // 2. Check form inputs & button
    const emailInput = page.locator('#email');
    const passwordInput = page.locator('#password');
    const submitBtn = page.locator('button[type="submit"]');

    await expect(emailInput).toBeVisible();
    await expect(passwordInput).toBeVisible();
    await expect(submitBtn).toBeVisible();

    // 3. Check demo fast-fill pills
    await expect(page.locator('text=Akses Cepat Akun Demo')).toBeVisible();
    await expect(page.locator('button:has-text("Admin / Guru")')).toBeVisible();
    await expect(page.locator('button:has-text("Siswa / Peserta")')).toBeVisible();

    await page.screenshot({ path: `screenshots/06_login_redesign${suffix}`, fullPage: true });
  });

  test('2. Admin Dashboard - Modern Hero, 4-Box Stat Grid, & Quick Access Cards', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    await page.goto('/home');

    // Check Navbar branding
    await expect(page.locator('.logo-lg:has-text("Latihan Soal Abdi Praja")')).toBeVisible();

    // Check Hero Card
    await expect(page.locator('text=/Selamat Datang/')).toBeVisible();
    await expect(page.locator('text=Latihan Soal Abdi Praja').first()).toBeVisible();

    // Check 4 Balanced Stat Cards
    await expect(page.locator('text=Jumlah Siswa')).toBeVisible();
    await expect(page.locator('text=Paket Soal').first()).toBeVisible();
    await expect(page.locator('text=Butir Soal').first()).toBeVisible();
    await expect(page.locator('text=Status Lisensi').first()).toBeVisible();

    // Check 3 Quick Access Cards
    await expect(page.locator('text=Mulai Latihan SKD Kedinasan')).toBeVisible();
    await expect(page.locator('text=Mulai Latihan UTBK-SNBT')).toBeVisible();
    await expect(page.locator('text=Lihat Rapor Nilai')).toBeVisible();

    await page.screenshot({ path: `screenshots/07_admin_dashboard_redesign${suffix}`, fullPage: true });
  });

  test('3. Siswa Dashboard - Centered Balanced View & Quick Access', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    await page.goto('/home');

    // Check Hero Card
    await expect(page.locator('text=/Selamat Datang/')).toBeVisible();

    // Check 4 Stat Cards
    await expect(page.locator('text=Jumlah Siswa')).toBeVisible();
    await expect(page.locator('text=Paket Soal').first()).toBeVisible();
    await expect(page.locator('text=Butir Soal').first()).toBeVisible();
    await expect(page.locator('text=Status Lisensi').first()).toBeVisible();

    // Check Quick Access Cards
    await expect(page.locator('text=Mulai Latihan SKD Kedinasan')).toBeVisible();
    await expect(page.locator('text=Mulai Latihan UTBK-SNBT')).toBeVisible();
    await expect(page.locator('text=Lihat Rapor Nilai')).toBeVisible();

    await page.screenshot({ path: `screenshots/08_siswa_dashboard_redesign${suffix}`, fullPage: true });
  });

  test('4. Siswa Exam Password Verification - Centered Elegant Card', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // Go to locked exam page (paket 8)
    await page.goto('/siswa/ujian/detail/8');

    // Check centered card elements
    await expect(page.locator('h2:has-text("Paket Soal Terkunci")')).toBeVisible();
    await expect(page.locator('#password')).toBeVisible();
    await expect(page.locator('#aktivasi')).toBeVisible();
    await expect(page.locator('text=Kembali ke Katalog Paket Soal')).toBeVisible();

    await page.screenshot({ path: `screenshots/09_password_ujian_redesign${suffix}`, fullPage: true });
  });

  test('5. Profile Settings - Centered Clean Card & Spacious Form Inputs', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // Go to Pengaturan
    await page.goto('/pengaturan');

    // Check centered settings card elements
    await expect(page.locator('text=Pengaturan Profil Pengguna')).toBeVisible();
    await expect(page.locator('#nama')).toHaveValue('Desi Chrisdamayanti Lubis');
    await expect(page.locator('#email')).toHaveValue('chrisdamayantidesi012@gmail.com');
    await expect(page.locator('#laki_laki')).toBeVisible();
    await expect(page.locator('#perempuan')).toBeVisible();
    await expect(page.locator('#password')).toBeVisible();
    await expect(page.locator('#update_profil')).toBeVisible();

    await page.screenshot({ path: `screenshots/10_pengaturan_profil_redesign${suffix}`, fullPage: true });
  });

});
