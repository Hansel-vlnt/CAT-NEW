import { test, expect } from '@playwright/test';

test.describe('Footer Zero Gap Verification Suite - All Pages', () => {

  test('Admin Pages: No gap below footer on short and long pages', async ({ page }) => {
    await page.setViewportSize({ width: 1280, height: 900 });
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/home');

    const adminPages = ['/home', '/pengaturan', '/elearning/soal', '/master/siswa', '/vouchers', '/elearning/laporan', '/elearning/materi'];

    for (const p of adminPages) {
      await page.goto(p);
      await page.waitForLoadState('networkidle');

      const info = await page.evaluate(() => {
        const footer = document.querySelector('.main-footer');
        const footerRect = footer.getBoundingClientRect();
        return {
          windowHeight: window.innerHeight,
          footerBottom: footerRect.bottom,
          gapBelowFooter: window.innerHeight - footerRect.bottom
        };
      });

      console.log(`[Admin-${p}] Footer Bottom: ${info.footerBottom}px (Window: ${info.windowHeight}px), Gap: ${info.gapBelowFooter}px`);
      expect(info.gapBelowFooter).toBeLessThanOrEqual(0.5);
    }
  });

  test('Siswa Pages: No gap below footer on short and long pages', async ({ page }) => {
    await page.setViewportSize({ width: 1280, height: 900 });
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL((url) => !url.pathname.includes('/login'));

    const siswaPages = ['/home', '/siswa/materi', '/pengaturan', '/siswa/ujian'];

    for (const p of siswaPages) {
      await page.goto(p);
      await page.waitForLoadState('networkidle');

      const info = await page.evaluate(() => {
        const footer = document.querySelector('.main-footer');
        const footerRect = footer.getBoundingClientRect();
        return {
          windowHeight: window.innerHeight,
          footerBottom: footerRect.bottom,
          gapBelowFooter: window.innerHeight - footerRect.bottom
        };
      });

      console.log(`[Siswa-${p}] Footer Bottom: ${info.footerBottom}px (Window: ${info.windowHeight}px), Gap: ${info.gapBelowFooter}px`);
      expect(info.gapBelowFooter).toBeLessThanOrEqual(0.5);
    }
  });

  test('Mobile: No gap below footer', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/home');

    await page.goto('/pengaturan');
    await page.waitForLoadState('networkidle');

    const info = await page.evaluate(() => {
      const footer = document.querySelector('.main-footer');
      const footerRect = footer.getBoundingClientRect();
      return {
        windowHeight: window.innerHeight,
        footerBottom: footerRect.bottom,
        gapBelowFooter: window.innerHeight - footerRect.bottom
      };
    });

    console.log(`[Mobile-Pengaturan] Footer Bottom: ${info.footerBottom}px, Gap: ${info.gapBelowFooter}px`);
    expect(info.gapBelowFooter).toBeLessThanOrEqual(0.5);
  });

});
