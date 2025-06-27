<?php
$queue_url = "https://dom-xss.onrender.com/admin_queue.txt";
$cookie = "admin_session=flag{n1c3_j0b_1n_8ssd0m_1nject10n}";
$useragent = "AdminBot/1.0";

$queue_content = @file_get_contents($queue_url);
if ($queue_content === false) {
    echo "Failed to fetch the queue file from the server.\n";
    exit(1);
}

$urls = array_filter(array_map('trim', explode("\n", $queue_content)));
if (empty($urls)) {
    echo "Queue is empty.\n";
    exit(0);
}

foreach ($urls as $url) {
    echo "[+] Visiting: $url\n";
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIE => $cookie,
        CURLOPT_USERAGENT => $useragent,
        CURLOPT_TIMEOUT => 10
    ]);
    curl_exec($ch);
    curl_close($ch);
}
