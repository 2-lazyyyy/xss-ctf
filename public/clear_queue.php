<?php
$queue_file = __DIR__ . '/admin_queue.txt';
file_put_contents($queue_file, ''); // Clear file content
echo "Queue cleared.";
?>
