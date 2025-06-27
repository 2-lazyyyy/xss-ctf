<?php
$queue_file = __DIR__ . "/public/admin_queue.txt";
$cookie = "admin_session=FLAG{this_is_the_admin_cookie}";
$useragent = "AdminBot/1.0";

if (!file_exists($queue_file)) {
    echo "No queue file.\n";
    exit;
}

$urls = file($queue_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
file_put_contents($queue_file, ""); // Clear the queue

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
