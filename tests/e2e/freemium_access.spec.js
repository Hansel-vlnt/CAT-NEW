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

test.describe('CBT Freemium & Membership Les E2E Tests', () => {

  test('1. Siswa Publik (Gratis) - Buka Katalog, Kerjakan Paket Gratis & Modal Voucher', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Login sebagai Siswa Gratis
    await page.goto('/login');
    await page.fill('#email', 'siswa_gratis@abdipraja.id');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // 2. Akses Katalog Ujian - Pastikan tidak tertendang ke /home!
    await page.goto('/siswa/ujian');
    await expect(page).toHaveURL(/\/siswa\/ujian/);
    await expect(page.locator('h1:has-text("Daftar Paket Latihan Soal")')).toBeVisible();

    // 3. Verifikasi Banner Siswa Reguler
    await expect(page.locator('text=Akun Reguler / Gratis')).toBeVisible();

    // Screenshot Katalog Siswa Publik
    await page.screenshot({ path: `screenshots/freemium_01_katalog_siswa_gratis${suffix}`, fullPage: true });

    // 4. Test Filter "Gratis (Trial)"
    await page.click('#btn-filter-gratis');
    await expect(page.locator('.paket-card:visible').first()).toBeVisible();
    await expect(page.locator('.paket-card:visible').first()).toContainText('Gratis');

    // 5. Kerjakan Paket Gratis (Latihan Kecerdasan #2 - ID 8)
    const btnMulaiGratis = page.locator('a:has-text("Mulai Latihan (Gratis)")').first();
    await expect(btnMulaiGratis).toBeVisible();
    await btnMulaiGratis.click();

    // Pastikan masuk ke halaman ujian detail_ujian (BUKAN password_ujian!)
    await expect(page).toHaveURL(/\/siswa\/ujian\/detail\/8/);
    await expect(page.locator('#pre-exam-box')).toBeVisible();
    await expect(page.locator('h1:has-text("Detail Soal Ujian")')).toBeVisible();
    // Verifikasi form password ujian TIDAK muncul sama sekali
    await expect(page.locator('#password_soal')).toHaveCount(0);
    await page.screenshot({ path: `screenshots/freemium_02_ujian_gratis_berjalan${suffix}` });

    // 6. Kembali ke Katalog dan Cek Paket Berbayar (Terkunci)
    await page.goto('/siswa/ujian');
    await page.click('#btn-filter-berbayar');
    const btnBukaAkses = page.locator('button:has-text("Buka Akses / Aktivasi")').first();
    await expect(btnBukaAkses).toBeVisible();

    // Klik tombol Buka Akses -> Muncul Modal Aktivasi Voucher
    await btnBukaAkses.click();
    await expect(page.locator('#modal-voucher')).toBeVisible();
    await expect(page.locator('#kode_voucher_input')).toBeVisible();

    // Screenshot Modal Aktivasi Voucher
    await page.screenshot({ path: `screenshots/freemium_03_modal_voucher_terkunci${suffix}` });

    // Tutup modal
    await page.click('button:has-text("Tutup")');
    await expect(page.locator('#modal-voucher')).toBeHidden();
  });

  test('2. Siswa Bimbingan Belajar (Les) - Dashboard Home Lisensi Aktif, Katalog & Modul Unlocked', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Login sebagai Siswa Les
    await page.goto('/login');
    await page.fill('#email', 'siswa_les@abdipraja.id');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // 2. Verifikasi Dashboard /home - Status Lisensi Aktif & #cekVoucher tidak muncul
    await page.goto('/home');
    await expect(page.locator('text=Lisensi Aktif')).toBeVisible();
    await expect(page.locator('text=31-12-2026')).toBeVisible();
    await expect(page.locator('#cekVoucher')).toHaveCount(0);

    // 3. Buka Katalog Ujian
    await page.goto('/siswa/ujian');
    await expect(page).toHaveURL(/\/siswa\/ujian/);

    // Verifikasi bahwa tidak ada tombol "Buka Akses / Aktivasi" yang terkunci
    const btnTerkunci = page.locator('button:has-text("Buka Akses / Aktivasi")');
    await expect(btnTerkunci).toHaveCount(0);

    // Seluruh paket memiliki tombol aktif Mulai Latihan
    const btnMulai = page.locator('a:has-text("Mulai Latihan")').first();
    await expect(btnMulai).toBeVisible();

    // Screenshot Katalog Siswa Les
    await page.screenshot({ path: `screenshots/freemium_04_katalog_siswa_les_unlocked${suffix}`, fullPage: true });

    // 4. Buka Modul Materi Belajar Siswa
    await page.goto('/siswa/materi');
    await expect(page.locator('text=👑 Siswa Les Aktif')).toBeVisible();

    // Tunggu DataTables selesai memuat data dan hilangnya processing indicator
    await page.waitForSelector('#table_soal tbody tr td');
    await page.waitForSelector('.dataTables_processing', { state: 'hidden', timeout: 5000 }).catch(() => {});
    await page.waitForTimeout(300);

    await page.screenshot({ path: `screenshots/freemium_05_materi_siswa_les${suffix}`, fullPage: true });
  });

  test('3. Admin Portal - Manajemen Akses Paket Soal, Materi & Status Siswa Les', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Login sebagai Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // 2. Kelola Paket Soal (Bank Soal)
    await page.goto('/elearning/soal');
    await expect(page.locator('#table_soal')).toBeVisible();
    await page.waitForSelector('#table_soal tbody tr td');
    await page.waitForSelector('.dataTables_processing', { state: 'hidden', timeout: 5000 }).catch(() => {});

    if (!isMobile) {
      await expect(page.locator('th:has-text("Akses")')).toBeVisible();
      await expect(page.locator('span:has-text("Gratis")').first()).toBeVisible();
    }

    // Buka formulir buat paket baru dan verifikasi input Tipe Akses & Toggle Harga
    await page.click('#btn-soal');
    await page.waitForFunction(() => {
      const el = document.querySelector('#wrap-soal');
      return el && window.getComputedStyle(el).display !== 'none';
    });
    await expect(page.locator('#tipe_akses')).toBeVisible();

    // Ubah ke berbayar -> tipe akses terupdate
    await page.selectOption('#tipe_akses', 'berbayar');
    await expect(page.locator('#tipe_akses')).toHaveValue('berbayar');

    await page.screenshot({ path: `screenshots/freemium_06_admin_bank_soal_form${suffix}`, fullPage: true });

    // 3. Kelola Data Siswa (Master Siswa)
    await page.goto('/master/siswa');
    await expect(page.locator('#tabel_siswa')).toBeVisible();
    await page.waitForSelector('#tabel_siswa tbody tr td');
    await page.waitForSelector('.dataTables_processing', { state: 'hidden', timeout: 5000 }).catch(() => {});

    if (!isMobile) {
      await expect(page.locator('th:has-text("Status Member")')).toBeVisible();
    }
    await page.screenshot({ path: `screenshots/freemium_07_admin_master_siswa${suffix}`, fullPage: true });

    // 4. Kelola Modul Materi Belajar
    await page.goto('/elearning/materi');
    await expect(page.locator('#table_materi')).toBeVisible();
    await page.waitForSelector('#table_materi tbody tr td');
    await page.waitForSelector('.dataTables_processing', { state: 'hidden', timeout: 5000 }).catch(() => {});

    if (!isMobile) {
      await expect(page.locator('th:has-text("Akses")')).toBeVisible();
    }
    await page.click('#btn-tambah-materi');
    await page.waitForFunction(() => {
      const el = document.querySelector('#wrap-form-materi');
      return el && window.getComputedStyle(el).display !== 'none';
    });
    await expect(page.locator('#wrap-form-materi #tipe_akses')).toBeVisible();
    await page.screenshot({ path: `screenshots/freemium_08_admin_materi_form${suffix}`, fullPage: true });
  });

  test('4. Backend Security Guarding - Pencegahan Bypass URL detailUjian dan finishUjian', async ({ page }, testInfo) => {
    const isMobile = testInfo.project.name.includes('Mobile');
    const suffix = isMobile ? '_mobile.png' : '_desktop.png';

    // 1. Login Siswa Gratis
    await page.goto('/login');
    await page.fill('#email', 'siswa_gratis@abdipraja.id');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // 2. Coba tembak langsung URL detail paket berbayar (ID 6)
    await page.goto('/siswa/ujian/detail/6');
    await expect(page).toHaveURL(/\/siswa\/ujian/);
    await expect(page.locator('text=Paket latihan ini khusus untuk siswa bimbingan belajar Abdi Praja')).toBeVisible();

    // 3. Coba tembak langsung URL finish paket berbayar (ID 6)
    await page.goto('/siswa/ujian/finish/6');
    await expect(page).toHaveURL(/\/siswa\/ujian/);
    await expect(page.locator('text=Paket latihan ini khusus untuk siswa bimbingan belajar Abdi Praja')).toBeVisible();

    await page.screenshot({ path: `screenshots/freemium_09_security_guard_blocked${suffix}`, fullPage: true });
  });

});
