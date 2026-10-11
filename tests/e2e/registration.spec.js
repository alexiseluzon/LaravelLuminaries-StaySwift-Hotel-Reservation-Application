import { test, expect } from '@playwright/test';
const base = process.env.BASE_URL || 'http://127.0.0.1:8000';

test.describe('registration form', () => {
    test.beforeEach(async ({ page }) => { await page.goto(base + '/registration'); });

    test('create button starts disabled', async ({ page }) => {
        await expect(page.locator('.submit-btn')).toBeDisabled();
    });

    test('names accept letters only', async ({ page }) => {
        await page.fill('#userFirstName', 'Juan123!');
        await expect(page.locator('#userFirstName')).toHaveValue('Juan');
    });

    test('phone is limited to 11 digits and shows an error when short', async ({ page }) => {
        await page.fill('#userPhone', '0917-123-45678999');
        await expect(page.locator('#userPhone')).toHaveValue('09171234567');
        await page.fill('#userPhone', '0917');
        await page.locator('#userPhone').blur();
        await expect(page.locator('#err-userPhone')).toBeVisible();
    });

    test('button enables only when every field is valid', async ({ page }) => {
        await page.fill('#userFirstName', 'Juan');
        await page.fill('#userLastName', 'Cruz');
        await page.fill('#userBirthdate', '2000-01-15');
        await page.fill('#userEmailAddress', 'juan@email.com');
        await page.fill('#userPhone', '09171234567');
        await page.fill('#userPassword', 'secret1');
        await expect(page.locator('.submit-btn')).toBeDisabled();
        await page.fill('#userConfirmPassword', 'secret1');
        await expect(page.locator('.submit-btn')).toBeEnabled();
        await expect(page.locator('#userAge')).not.toHaveValue('');
    });
});