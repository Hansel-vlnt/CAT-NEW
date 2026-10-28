// @ts-check
const { test, expect } = require('@playwright/test');
const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

test.beforeAll(async () => {
  const screenshotsDir = path.join(__dirname, '../../screenshots');
  if (!fs.existsSync(screenshotsDir)) {
    fs.mkdirSync(screenshotsDir, { recursive: true });
  }

  // Bersihkan data tes sebelumnya
  try {
    execSync('php tests/cleanup_test_pkg.php', {
      cwd: path.join(__dirname, '../../')
    });
  } catch (e) {}
});

test.describe('E2E Custom Paket Langganan & Pricing Cards Pass', () => {

  test('1. Admin Portal - Manajemen Paket Langganan Custom (List, Tambah Custom Bulan & Harga)', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Login sebagai Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // 2. Buka menu Paket Langganan
    await page.goto('/paket-langganan');
    await expect(page.locator('h1:has-text("Manajemen Paket Langganan CBT")')).toBeVisible();

    // 3. Verifikasi paket default berbasis standar industri muncul
    await expect(page.locator('#table_paket').locator('text=Pass 1 Bulan - Sprint SKD')).toBeVisible();
    await expect(page.locator('#table_paket').locator('text=Pass 3 Bulan - Intensif Kedinasan')).toBeVisible();
    await expect(page.locator('#table_paket').locator('text=Pass 6 Bulan - Platinum All Season')).toBeVisible();

    // Screenshot Admin Paket Langganan
    await page.screenshot({ path: `screenshots/admin_paket_langganan_list${suffix}`, fullPage: true });

    // 4. Buka Modal Tambah Paket Custom
    await page.click('button:has-text("Tambah Paket Custom")');
    await expect(page.locator('#modal-tambah-paket')).toBeVisible();
    await expect(page.locator('#nama_paket')).toBeVisible();

    // Isi formulir paket custom
    await page.fill('#nama_paket', 'Pass 4 Bulan - Super Intensif SKD');
    await page.fill('#badge', 'Terlaris Batch 2');
    await page.fill('#durasi_bulan', '4');
    // Trigger oninput
    await page.locator('#durasi_bulan').dispatchEvent('input');
    await expect(page.locator('#durasi_hari')).toHaveValue('120');

    await page.fill('#harga', '129000');
    await page.fill('#harga_coret', '249000');
    await page.fill('#deskripsi', 'Program bimbingan 4 bulan persiapan menyeluruh.');
    await page.fill('#fitur', 'Akses Semua Tryout CAT Kedinasan\nPembahasan Soal Lengkap & Trik Cepat\nRanking Nasional Real-time');

    // Screenshot modal tambah paket
    await page.screenshot({ path: `screenshots/admin_modal_tambah_paket${suffix}` });

    // Submit form
    await page.click('#modal-tambah-paket button[type="submit"]');
    await page.waitForURL(/\/paket-langganan/);
    await expect(page.locator('#table_paket').locator('text=Pass 4 Bulan - Super Intensif SKD').first()).toBeVisible();
    await expect(page.locator('#table_paket').locator('text=Rp 129.000').first()).toBeVisible();
  });

  test('2. Siswa Portal - Tampilan Pricing Pass & Modal Langganan Siswa', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Login sebagai Siswa Gratis
    await page.goto('/login');
    await page.fill('#email', 'siswa_gratis@abdipraja.id');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // 2. Buka Katalog Soal
    await page.goto('/siswa/ujian');
    await expect(page.locator('text=Buka Akses Penuh ke Seluruh Paket Soal')).toBeVisible();

    // 3. Klik tombol "Lihat Paket Pass"
    await page.click('button:has-text("Lihat Paket Pass")');
    await expect(page.locator('#modal-voucher')).toBeVisible();

    // 4. Verifikasi Pricing Cards tampil dinamis
    const modal = page.locator('#modal-voucher');
    await expect(modal.locator('text=Pass 1 Bulan - Sprint SKD').first()).toBeVisible();
    await expect(modal.locator('text=Pass 3 Bulan - Intensif Kedinasan').first()).toBeVisible();
    await expect(modal.locator('text=Pass 6 Bulan - Platinum All Season').first()).toBeVisible();

    // Verifikasi tombol Beli via WhatsApp memuat nomor resmi 0857-6762-9211
    const waLink = modal.locator('a[href*="wa.me/6285767629211"]').first();
    await expect(waLink).toBeVisible();

    // Verifikasi form voucher tetap tersedia di bawah
    await expect(modal.locator('#kode_voucher_input')).toBeVisible();

    // Screenshot Siswa Pricing Pass Modal
    await page.screenshot({ path: `screenshots/siswa_pricing_pass_modal${suffix}` });

    // Tutup Modal
    await modal.locator('button:has-text("Tutup")').click();
    await expect(modal).toBeHidden();
  });

});
