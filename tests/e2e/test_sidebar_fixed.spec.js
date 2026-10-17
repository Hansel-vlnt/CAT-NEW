import { test, expect } from '@playwright/test';

test.describe('Sticky / Fixed Sidebar & Header Verification', () => {

  test('Desktop: Sidebar and Header remain fixed on scroll', async ({ page }) => {
    await page.setViewportSize({ width: 1280, height: 900 });
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/home');

    // 1. Verify fixed classes and computed styles before scroll
    const hasFixedClass = await page.evaluate(() => document.body.classList.contains('fixed'));
    expect(hasFixedClass).toBe(true);

    const initial = await page.evaluate(() => {
      const header = document.querySelector('.main-header');
      const sidebar = document.querySelector('.main-sidebar');
      const content = document.querySelector('.content-wrapper');
      return {
        headerPos: getComputedStyle(header).position,
        sidebarPos: getComputedStyle(sidebar).position,
        contentPaddingTop: getComputedStyle(content).paddingTop,
        headerRectTop: header.getBoundingClientRect().top,
        sidebarRectTop: sidebar.getBoundingClientRect().top,
      };
    });

    expect(initial.headerPos).toBe('fixed');
    expect(initial.sidebarPos).toBe('fixed');
    expect(initial.headerRectTop).toBe(0);
    expect(initial.sidebarRectTop).toBe(0);

    // 2. Scroll down 600px
    await page.evaluate(() => window.scrollTo(0, 600));
    await page.waitForTimeout(300);

    const scrolled = await page.evaluate(() => {
      const header = document.querySelector('.main-header');
      const sidebar = document.querySelector('.main-sidebar');
      return {
        scrollY: window.scrollY,
        headerRectTop: header.getBoundingClientRect().top,
        sidebarRectTop: sidebar.getBoundingClientRect().top,
      };
    });

    expect(scrolled.scrollY).toBeGreaterThanOrEqual(50);
    expect(scrolled.headerRectTop).toBe(0);
    expect(scrolled.sidebarRectTop).toBe(0);

    // Capture screenshot of scrolled state
    await page.screenshot({ path: 'tests/e2e/screenshots/sticky_sidebar_desktop_scrolled.png' });
  });

  test('Desktop: Sidebar toggle collapse/expand works cleanly with fixed shell', async ({ page }) => {
    await page.setViewportSize({ width: 1280, height: 900 });
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/home');

    // Toggle collapse
    await page.click('.sidebar-toggle');
    await page.waitForTimeout(300);
    const collapsedWidth = await page.evaluate(() => document.querySelector('.main-sidebar').getBoundingClientRect().width);
    expect(collapsedWidth).toBeLessThan(70);

    // Toggle expand
    await page.click('.sidebar-toggle');
    await page.waitForTimeout(300);
    const expandedWidth = await page.evaluate(() => document.querySelector('.main-sidebar').getBoundingClientRect().width);
    expect(expandedWidth).toBeGreaterThan(220);
  });

  test('Mobile: Fixed header and sliding drawer sidebar', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/login');
    await page.fill('#email', 'admin@abdipraja.co.id');
    await page.fill('#password', 'admin123');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/home');

    // Initially sidebar is hidden offscreen on mobile
    const initialSidebarX = await page.evaluate(() => document.querySelector('.main-sidebar').getBoundingClientRect().left);
    expect(initialSidebarX).toBeLessThan(0);

    // Open sidebar on mobile
    await page.click('.sidebar-toggle');
    await page.waitForTimeout(300);

    const openSidebarX = await page.evaluate(() => document.querySelector('.main-sidebar').getBoundingClientRect().left);
    expect(openSidebarX).toBeCloseTo(0, 0);

    await page.screenshot({ path: 'tests/e2e/screenshots/sticky_sidebar_mobile_open.png' });
  });

});
