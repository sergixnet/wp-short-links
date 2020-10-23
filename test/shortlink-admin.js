const puppeteer = require('puppeteer');
const { assert, expect } = require('chai');

describe('User admin', function () {
	const BASE_URL = 'http://localhost:8888';
	const ADMIN_URL = `${BASE_URL}/wp-admin`;
	const title = 'Example test';
	const slug = 'slugtest';
	const targetUrl = 'https://google.com';

	let browser;
	let page;

	beforeEach(async function () {
		browser = await puppeteer.launch({ headless: true });
		page = await browser.newPage();

		// Login to WordPress
		await page.goto(ADMIN_URL);
		await page.type('input#user_login', 'admin');
		await page.type('input#user_pass', 'password');
		await page.click('input#wp-submit');
	});

	it('can create a shortlink.', async function () {
		await page.waitForXPath(
			'/html/body/div[1]/div[1]/div[2]/ul/li[4]/ul/li[3]/a'
		);

		await page.click(
			'li#menu-posts-shortlink.wp-has-submenu.wp-not-current-submenu.menu-top.menu-icon-shortlink a.wp-has-submenu.wp-not-current-submenu.menu-top.menu-icon-shortlink'
		);

		// Add new Shortlink
		await page.waitForSelector('a.page-title-action');
		await page.click('a.page-title-action');
		await page.waitForSelector('input#title');
		await page.type('input#title', title);
		await page.type('input#slug', slug);
		await page.type('input#shortlink_target_url', targetUrl);
		await page.click('input#publish');

		await page.waitForSelector('#message');
		const successMessage = await page.$eval(
			'#message p',
			(el) => el.outerHTML
		);
		const result = successMessage.includes('Post published.');
		expect(result).to.be.true;
	}).timeout(10000);

	it('can edit a shortlink.', async function () {
		await page.waitForXPath(
			'/html/body/div[1]/div[1]/div[2]/ul/li[4]/ul/li[3]/a'
		);

		await page.click(
			'li#menu-posts-shortlink.wp-has-submenu.wp-not-current-submenu.menu-top.menu-icon-shortlink a.wp-has-submenu.wp-not-current-submenu.menu-top.menu-icon-shortlink'
		);

		await page.waitForXPath(
			'/html/body/div[1]/div[2]/div[2]/div[1]/div[3]/form[1]/table/tbody/tr[1]/td[1]/strong/a'
		);

		await page.click('a.row-title');
		await page.waitForSelector('input#publish');

		const titleInput = await page.$('input#title');
		await titleInput.click({ clickCount: 3 });
		await titleInput.press('Backspace');
		await titleInput.type(title + ' edited');
		await page.click('input#publish');

		await page.waitForSelector('#message');
		const successMessage = await page.$eval(
			'#message p',
			(el) => el.outerHTML
		);
		const result = successMessage.includes('Post updated.');
		expect(result).to.be.true;
	});

	it('can delete a shortlink.', async function () {
		await page.waitForXPath(
			'/html/body/div[1]/div[1]/div[2]/ul/li[4]/ul/li[3]/a'
		);

		await page.click(
			'li#menu-posts-shortlink.wp-has-submenu.wp-not-current-submenu.menu-top.menu-icon-shortlink a.wp-has-submenu.wp-not-current-submenu.menu-top.menu-icon-shortlink'
		);

		await page.waitForSelector('a.row-title');
		await page.hover('a.row-title');
		await page.click('.trash a.submitdelete');

		await page.waitForSelector('#message');
		const successMessage = await page.$eval(
			'#message p',
			(el) => el.outerHTML
		);
		const result = successMessage.includes('1 post moved to the Trash.');
		expect(result).to.be.true;
	});

	afterEach(async function () {
		await browser.close();
	});
});
