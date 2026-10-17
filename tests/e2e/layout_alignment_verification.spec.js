import { test, expect } from '@playwright/test';

test.describe('Layout Alignment Verification Suite', () => {
  test('Admin Pages Left Grid Alignment Consistency', async ({ page }) => {
    test.setTimeout(60000);
    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    const checkAlignment = async (path, pageName) => {
      await page.goto(path);
      await page.waitForLoadState('networkidle');

      // Check breadcrumb container and content container
      const breadcrumbBox = await page.locator('.content-header > div').first().boundingBox();
      const contentCardBox = await page.locator('.content [class*="max-w-"]').first().boundingBox();

      expect(breadcrumbBox).not.toBeNull();
      expect(contentCardBox).not.toBeNull();

      console.log(`[${pageName}] Breadcrumb X: ${breadcrumbBox.x.toFixed(1)}px, ContentCard X: ${contentCardBox.x.toFixed(1)}px`);
      // Both must align to the exact same left anchor line (within 2px tolerance)
      expect(Math.abs(breadcrumbBox.x - contentCardBox.x)).toBeLessThanOrEqual(2);

      await page.screenshot({ path: `tests/e2e/screenshots/align_${pageName}.png` });
    };

    await checkAlignment('/home', 'dashboard');
    await checkAlignment('/pengaturan', 'pengaturan');
    await checkAlignment('/elearning/soal', 'bank_soal');
    await checkAlignment('/master/siswa', 'master_siswa');
    await checkAlignment('/vouchers', 'vouchers');
    await checkAlignment('/elearning/laporan', 'laporan');
    await checkAlignment('/elearning/materi', 'materi');
  });

  test('Siswa Pages Left Grid Alignment Consistency', async ({ page }) => {
    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    const checkAlignment = async (path, pageName) => {
      await page.goto(path);
      await page.waitForLoadState('networkidle');

      const breadcrumbBox = await page.locator('.content-header > div').first().boundingBox();
      const contentCardBox = await page.locator('.content [class*="max-w-"]').first().boundingBox();

      expect(breadcrumbBox).not.toBeNull();
      expect(contentCardBox).not.toBeNull();

      console.log(`[Siswa-${pageName}] Breadcrumb X: ${breadcrumbBox.x.toFixed(1)}px, ContentCard X: ${contentCardBox.x.toFixed(1)}px`);
      expect(Math.abs(breadcrumbBox.x - contentCardBox.x)).toBeLessThanOrEqual(2);

      await page.screenshot({ path: `tests/e2e/screenshots/align_siswa_${pageName}.png` });
    };

    await checkAlignment('/siswa/ujian', 'katalog');
    await checkAlignment('/siswa/materi', 'materi');
    await checkAlignment('/pengaturan', 'pengaturan');
  });
});
