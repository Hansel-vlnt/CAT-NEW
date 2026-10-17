import { test, expect } from '@playwright/test';

test.describe('Layout Alignment Verification Suite', () => {
  test('Admin Pages Left Grid Alignment Consistency & Centered Dashboard Content', async ({ page }) => {
    test.setTimeout(60000);
    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    // 1. Dashboard: Content header at top-left, content grid centered, no subtitle paragraph below h1
    await page.goto('/home');
    await page.waitForLoadState('networkidle');

    const breadcrumbBox = await page.locator('.content-header > div').first().boundingBox();
    const contentCardBox = await page.locator('.content [class*="max-w-"]').first().boundingBox();
    console.log(`[Dashboard] Breadcrumb X: ${breadcrumbBox.x.toFixed(1)}px, ContentCard X: ${contentCardBox.x.toFixed(1)}px`);

    // Breadcrumb should be left-anchored at ~258px
    expect(breadcrumbBox.x).toBeCloseTo(258, 0);
    // ContentCard should be centered (X > 350px on desktop)
    expect(contentCardBox.x).toBeGreaterThan(300);

    // Verify subtitle paragraph below h1 is deleted
    const subtitleParagraph = page.locator('.content-header p');
    await expect(subtitleParagraph).toHaveCount(0);

    await page.screenshot({ path: `tests/e2e/screenshots/align_dashboard_centered.png` });

    const checkAlignment = async (path, pageName) => {
      await page.goto(path);
      await page.waitForLoadState('networkidle');

      const bBox = await page.locator('.content-header > div').first().boundingBox();
      const cBox = await page.locator('.content [class*="max-w-"]').first().boundingBox();

      expect(bBox).not.toBeNull();
      expect(cBox).not.toBeNull();

      console.log(`[${pageName}] Breadcrumb X: ${bBox.x.toFixed(1)}px, ContentCard X: ${cBox.x.toFixed(1)}px`);
      expect(Math.abs(bBox.x - cBox.x)).toBeLessThanOrEqual(2);

      await page.screenshot({ path: `tests/e2e/screenshots/align_${pageName}.png` });
    };

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
