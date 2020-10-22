const got = require('got');
const { expect } = require('chai');

const BASE_URL = 'http://localhost:8888';
const ENDPOINT_URL = `${BASE_URL}/wp-json/sl/v1/shortlinks`;

let response, statusCode, body, shortLinks;

describe('Short Links API', async function () {
	before(async function () {
		response = await got(ENDPOINT_URL);
		statusCode = response.statusCode;
		body = response.body;
		shortLinks = JSON.parse(body);
	});

	it('should respond with an array of objects.', async function () {
		expect(statusCode).to.equal(200);
		expect(shortLinks).to.be.a('array');
		shortLinks.forEach((el) => {
			expect(el).to.be.a('object');
		});
	});

	it('id key should be a number.', async function () {
		const id = shortLinks[0].id;

		expect(statusCode).to.equal(200);
		expect(id).to.be.a('number');
	});

	it('title key should be a string.', async function () {
		const title = shortLinks[0].title;

		expect(statusCode).to.equal(200);
		expect(title).to.be.a('string');
	});

	it('slug key should be a string.', async function () {
		const slug = shortLinks[0].slug;

		expect(statusCode).to.equal(200);
		expect(slug).to.be.a('string');
	});

	it('date key should be a string.', async function () {
		const date = shortLinks[0].date;

		expect(statusCode).to.equal(200);
		expect(date).to.be.a('string');
	});

	it('permalink key should be a string.', async function () {
		const permalink = shortLinks[0].permalink;

		expect(statusCode).to.equal(200);
		expect(permalink).to.be.a('string');
	});

	it('target_url key should be a string.', async function () {
		const targetUrl = shortLinks[0].target_url;

		expect(statusCode).to.equal(200);
		expect(targetUrl).to.be.a('string');
	});

	it('hits key should be a number.', async function () {
		const hits = shortLinks[0].hits;

		expect(statusCode).to.equal(200);
		expect(hits).to.be.a('number');
	});
});

describe('Short Link redirection', function () {
	beforeEach(async function () {
		response = await got(ENDPOINT_URL);
		statusCode = response.statusCode;
		body = response.body;
		shortLinks = JSON.parse(body);
	});

	afterEach(function () {
		response, statusCode, body, (shortLinks = undefined);
	});

	it('should make a redirect.', async function () {
		const shortLink = shortLinks[0];
		const { permalink, target_url } = shortLink;
		const redirectResponse = await got(permalink);
		const targetRedirectUrl = redirectResponse.url;

		expect(targetRedirectUrl).to.equal(target_url);
	});

	it('should increment hits by one.', async function () {
		shortLink = shortLinks[0];
		const { hits, permalink, id } = shortLink;
		await got(permalink);
		response = await got(ENDPOINT_URL);
		body = response.body;
		shortLinks = JSON.parse(body);
		shortLink = shortLinks.find(element => element.id === id);
		const newHits = shortLink.hits;
		const result = hits + 1;
		expect(result).to.equal(newHits);
	});
});
