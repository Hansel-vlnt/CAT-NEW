import { test, expect } from '@playwright/test';

test.describe('Layout Alignment Verification Suite - Centered Content & Top-Left Clean Header', () => {
  test('Admin Pages: Clean Top-Left Header & Centered Content Cards', async ({ page }) => {
    test.setTimeout(90000);
    // Login as Admin
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    const checkPage = async (path, pageName) => {
      await page.goto(path);
      await page.waitForLoadState('networkidle');

      const breadcrumbBox = await page.locator('.content-header > div').first().boundingBox();
      const contentCardBox = await page.locator('.content [class*="max-w-"]').first().boundingBox();

      expect(breadcrumbBox).not.toBeNull();
      expect(contentCardBox).not.toBeNull();

      console.log(`[Admin-${pageName}] Header X: ${breadcrumbBox.x.toFixed(1)}px, Content X: ${contentCardBox.x.toFixed(1)}px`);

      // 1. Header is left-anchored at standard sidebar line (~258px on desktop)
      expect(breadcrumbBox.x).toBeCloseTo(258, 0);

      // 2. Content card is centered horizontally via mx-auto (X significantly greater than 258px)
      expect(contentCardBox.x).toBeGreaterThan(280);

      // 3. No subtitle paragraph below h1 in header
      const subtitleParagraph = page.locator('.content-header p');
      await expect(subtitleParagraph).toHaveCount(0);

      await page.screenshot({ path: `tests/e2e/screenshots/all_centered_${pageName}.png` });
    };

    await checkPage('/home', 'dashboard');
    await checkPage('/pengaturan', 'pengaturan');
    await checkPage('/elearning/soal', 'bank_soal');
    await checkPage('/master/siswa', 'master_siswa');
    await checkPage('/vouchers', 'vouchers');
    await checkPage('/elearning/laporan', 'laporan');
    await checkPage('/elearning/materi', 'materi');
  });

  test('Siswa Pages: Clean Top-Left Header & Centered Content Cards', async ({ page }) => {
    test.setTimeout(60000);
    // Login as Siswa
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 10000 });

    const checkPage = async (path, pageName) => {
      await page.goto(path);
      await page.waitForLoadState('networkidle');

      const breadcrumbBox = await page.locator('.content-header > div').first().boundingBox();
      const contentCardBox = await page.locator('.content [class*="max-w-"]').first().boundingBox();

      expect(breadcrumbBox).not.toBeNull();
      expect(contentCardBox).not.toBeNull();

      console.log(`[Siswa-${pageName}] Header X: ${breadcrumbBox.x.toFixed(1)}px, Content X: ${contentCardBox.x.toFixed(1)}px`);

      // 1. Header is left-anchored
      expect(breadcrumbBox.x).toBeCloseTo(258, 0);

      // 2. Content card is centered horizontally
      expect(contentCardBox.x).toBeGreaterThan(280);

      // 3. No subtitle paragraph in header
      const subtitleParagraph = page.locator('.content-header p');
      await expect(subtitleParagraph).toHaveCount(0);

      await page.screenshot({ path: `tests/e2e/screenshots/all_centered_siswa_${pageName}.png` });
    };

    await checkPage('/siswa/ujian', 'katalog');
    await checkPage('/siswa/materi', 'materi');
    await checkPage('/pengaturan', 'pengaturan');
  });
});
