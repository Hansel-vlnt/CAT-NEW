// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('Admin Master Siswa - Membership Status Toggle Tests', () => {

  test('Admin dapat mengubah status siswa dari Les ke Reguler dan sebaliknya secara real-time', async ({ page }) => {
    // 1. Login sebagai Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    // 2. Buka form edit siswa 527 (Desi Chrisdamayanti)
    await page.goto('/master/siswa/edit/527');
    await expect(page.locator('#status_langganan')).toBeVisible();

    // 3. Ubah status menjadi "Siswa Reguler (Gratis)"
    await page.selectOption('#status_langganan', 'gratis');
    // Verifikasi input tanggal berakhir otomatis tersembunyi
    await expect(page.locator('#wrap_tgl_berakhir_les')).toBeHidden();

    // 4. Simpan perubahan
    await page.click('#simpan');
    await page.waitForURL(/\/master\/siswa\/detail\/527/, { timeout: 10000 });

    // 5. Verifikasi di halaman Detail Siswa menampilkan status Reguler
    await expect(page.locator('text=Siswa Reguler (Gratis)')).toBeVisible();

    // 6. Buka halaman daftar /master/siswa dan cek baris siswa di tabel
    await page.goto('/master/siswa');
    await page.waitForSelector('#tabel_siswa tbody tr td');
    await page.waitForSelector('.dataTables_processing', { state: 'hidden', timeout: 5000 }).catch(() => {});

    // Cari siswa Desi
    await page.fill('#tabel_siswa_filter input', 'Desi Chrisdamayanti');
    await page.waitForTimeout(500);

    // Verifikasi badge status pada tabel menampilkan "Reguler / Gratis"
    const rowBadge = page.locator('#tabel_siswa tbody tr').first();
    await expect(rowBadge).toContainText('Reguler / Gratis');
    await expect(rowBadge).not.toContainText('👑 Siswa Les');

    // 7. Ubah kembali ke "👑 Siswa Bimbingan Belajar (Les)" untuk menguji siklus bolak-balik
    await page.goto('/master/siswa/edit/527');
    await page.selectOption('#status_langganan', 'les');
    await expect(page.locator('#wrap_tgl_berakhir_les')).toBeVisible();

    await page.click('#simpan');
    await page.waitForURL(/\/master\/siswa\/detail\/527/, { timeout: 10000 });

    // Verifikasi di detail berubah menjadi Siswa Les
    await expect(page.locator('text=👑 Siswa Les').first()).toBeVisible();

    // 8. Terakhir, ubah kembali ke "gratis" sesuai preferensi user
    await page.goto('/master/siswa/edit/527');
    await page.selectOption('#status_langganan', 'gratis');
    await page.click('#simpan');
    await page.waitForURL(/\/master\/siswa\/detail\/527/, { timeout: 10000 });
    await expect(page.locator('text=Siswa Reguler (Gratis)')).toBeVisible();
  });

});
