<?php
$message = "";
$allowed_prefix = "https://dom-xss.onrender.com"; // Replace with your Render URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'] ?? '';

    if (str_starts_with($url, $allowed_prefix)) {
        file_put_contents(__DIR__ . "/admin_queue.txt", $url . PHP_EOL, FILE_APPEND);
        $message = "URL submitted to admin!";
    } else {
        $message = "URL must start with $allowed_prefix";
    }
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Contact Admin</title></head>
<body>
<h2>Contact Page</h2>
<p><a href="index.php">Main</a> | <a href="contact.php">Contact</a></p>
<hr>
<?php if ($message) echo "<p><strong>$message</strong></p>"; ?>
<form method="POST">
    <label>Submit your issue:</label><br>
    <input type="text" name="url" style="width: 100%;" placeholder="<?= $allowed_prefix ?>?number=..."><br><br>
    <input type="submit" value="Submit to Admin">
</form>
</body>
</html>
