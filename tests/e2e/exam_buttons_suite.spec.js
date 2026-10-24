import { test, expect } from '@playwright/test';

test.describe('Exam Action Buttons, Submission & Reset-to-Zero Verification', () => {

  test('Exam Screen Buttons, Flow & Clean Retake From Zero on Desktop and Mobile', async ({ page }) => {
    // 1. Login as Student
    await page.goto('/login');
    await page.fill('#email', 'chrisdamayantidesi012@gmail.com');
    await page.fill('#password', 'siswa123');
    await page.click('button[type="submit"]');
    await page.waitForURL(url => !url.pathname.includes('/login'), { timeout: 10000 });

    // 2. Open Exam 8
    await page.goto('/siswa/ujian/detail/8');

    // Click Start Exam if briefing is shown
    const startBtn = page.locator('#start-exam');
    if (await startBtn.isVisible()) {
      await startBtn.click();
      await page.waitForTimeout(500);
    }
    await expect(page.locator('#specialstuff')).toBeVisible();

    // 3. Question 1 initial state
    await expect(page.locator('#no_soal_detail')).toHaveText('1');
    const prevBtn = page.locator('#prev');
    const nextBtn = page.locator('#next');
    const raguBtn = page.locator('#btn-ragu');
    const kirimBtn = page.locator('#kirim');

    await expect(prevBtn).toBeDisabled();
    await expect(nextBtn).toBeEnabled();
    await expect(raguBtn).toBeVisible();
    await expect(kirimBtn).toBeVisible();

    // 4. Test selecting an option (.jawab) on Question 1
    const firstOption = page.locator('.jawab').first();
    await firstOption.click();
    await expect(firstOption).toHaveClass(/dijawab/);

    // 5. Test #next navigation to Question 2
    await nextBtn.click();
    await page.waitForTimeout(800);
    await expect(page.locator('#no_soal_detail')).toHaveText('2');
    await expect(prevBtn).toBeEnabled();

    // Answer Question 2 and mark Ragu-ragu
    await page.locator('.jawab').first().click();
    await raguBtn.click();
    await page.waitForTimeout(400);
    await expect(raguBtn).toContainText('Hapus Ragu');
    const activeNav2 = page.locator('.no_soal[data-no="2"] a');
    await expect(activeNav2).toHaveClass(/btn-warning/);

    // 6. Test palette direct jump to Question 3
    const nav3 = page.locator('.no_soal[data-no="3"]');
    await nav3.click();
    await page.waitForTimeout(800);
    await expect(page.locator('#no_soal_detail')).toHaveText('3');

    // 7. Test #kirim -> SweetAlert confirmation -> Finish Page while on Question 3
    await kirimBtn.click();
    const swalPopup = page.locator('.swal2-popup');
    await expect(swalPopup).toBeVisible();

    const swalConfirm = page.locator('.swal2-confirm');
    await expect(swalConfirm).toBeVisible();
    await swalConfirm.click();

    // Verify student is redirected to finish scorecard
    await page.waitForURL(url => url.pathname.includes('/finish/8'), { timeout: 10000 });
    await expect(page.locator('text=Rapor Hasil Latihan')).toBeVisible();

    // 8. Verify Retake starts 100% from ZERO (not resuming at Question 3 or keeping old answers)
    await page.goto('/siswa/ujian/detail/8');
    await expect(page.locator('#pre-exam-box')).toBeVisible();
    await expect(page.locator('#specialstuff')).toBeHidden();

    await page.locator('#start-exam').click();
    await page.waitForTimeout(500);

    await expect(page.locator('#specialstuff')).toBeVisible();
    await expect(page.locator('#no_soal_detail')).toHaveText('1');
    await expect(page.locator('.jawab.dijawab')).toHaveCount(0);
    await expect(page.locator('.no_soal a.btn-success')).toHaveCount(0);
    await expect(page.locator('.no_soal a.btn-warning')).toHaveCount(0);
  });

});
