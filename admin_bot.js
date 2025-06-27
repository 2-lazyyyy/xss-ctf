const puppeteer = require('puppeteer');
const fs = require('fs');

const QUEUE_URL = 'https://dom-xss.onrender.com/admin_queue.txt';
const ADMIN_COOKIE = {
    name: 'admin_session',
    value: 'flag{n1c3_j0b_1n_8ssd0m_1nject10n}',
    path: '/',
    httpOnly: false,
    url: 'https://dom-xss.onrender.com', // Matches the target site
};

// Custom delay function
const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

(async () => {
    console.log('[*] Fetching queue...');

    // Use global fetch or fallback to node-fetch
    let fetchFn;
    try {
        fetchFn = (typeof fetch !== 'undefined') ? fetch : (...args) => import('node-fetch').then(({ default: fetch }) => fetch(...args));
    } catch (e) {
        console.error('[!] Failed to load fetch module:', e.message);
        return;
    }

    let res;
    try {
        res = await fetchFn(QUEUE_URL);
    } catch (e) {
        console.error('[!] Failed to fetch queue:', e.message);
        return;
    }

    if (!res.ok) {
        console.error(`[!] Failed to fetch queue: HTTP ${res.status}`);
        return;
    }

    const data = await res.text();
    // Split URLs, filter out empty lines, and deduplicate
    const urls = [...new Set(data.split('\n').filter(url => url.trim() && isValidUrl(url)))];

    if (urls.length === 0) {
        console.log('[!] Queue is empty.');
        return;
    }

    let browser;
    try {
        browser = await puppeteer.launch({ headless: true });
        const page = await browser.newPage();

        // Set the cookie
        await page.setCookie(ADMIN_COOKIE);

        for (const url of urls) {
            try {
                console.log(`[+] Visiting: ${url}`);
                await page.goto(url, { waitUntil: 'load', timeout: 10000 });
                // Wait for 3 seconds using custom delay
                await delay(3000);
            } catch (e) {
                console.error(`[!] Error visiting ${url}: ${e.message}`);
            }
        }
    } catch (e) {
        console.error('[!] Browser error:', e.message);
    } finally {
        if (browser) {
            await browser.close();
        }
        console.log('[*] Done.');
    }
})();

// Helper function to validate URLs
function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}