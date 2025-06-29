const puppeteer = require('puppeteer');
const fs = require('fs');

const QUEUE_URL = 'https://dom-xss.onrender.com/admin_queue.txt';
const ADMIN_COOKIE = {
    name: 'admin_session',
    value: 'flag{n1c3_j0b_1n_8ssd0m_1nject10n}',
    path: '/',
    httpOnly: false,
    domain: 'dom-xss.onrender.com',
};

const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

async function fetchFn(...args) {
    if (typeof fetch !== 'undefined') {
        return fetch(...args);
    } else {
        const { default: fetch } = await import('node-fetch');
        return fetch(...args);
    }
}

function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

async function checkQueueAndVisit() {
    console.log('[*] Fetching queue...');

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
    const urls = [...new Set(data.split('\n').map(url => url.trim()).filter(isValidUrl))];

    if (urls.length === 0) {
        console.log('[!] Queue is empty.');
        return;
    }

    let browser;
    try {
        browser = await puppeteer.launch({
            headless: true,
            timeout: 60000,
            protocolTimeout: 60000,
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });

        const page = await browser.newPage();
        await page.setCookie(ADMIN_COOKIE);

        for (const url of urls) {
            try {
                console.log(`[+] Visiting: ${url}`);
                await page.goto(url, { waitUntil: 'load', timeout: 10000 });
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
}

(async () => {
    while (true) {
        await checkQueueAndVisit();
        console.log('[*] Waiting 3 minutes before next check...\n');
        await delay(180000); // 3 minutes
    }
})();
