<?php
$message = "";
$allowed_prefix = "https://dom-xss.onrender.com"; // Replace with your Render URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'] ?? '';

    if (str_starts_with($url, $allowed_prefix)) {
        file_put_contents(__DIR__ . "/admin_queue.txt", $url . PHP_EOL, FILE_APPEND);
        $message = "✅ URL submitted to admin!";
    } else {
        $message = "❌ URL must start with <code>$allowed_prefix</code>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Admin - DOM XSS CTF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        h2 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        nav {
            margin-bottom: 20px;
        }

        nav a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 600;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            background: white;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
            color: #555;
            text-align: left;
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            padding: 12px 25px;
            font-size: 1.1rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-weight: 600;
            width: 100%;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .message {
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 1rem;
            color: #333;
        }

        .message strong, .message code {
            font-family: monospace;
        }

        footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Contact Page</h2>
    <nav>
        <a href="index.php">Main</a> | 
        <a href="contact.php">Contact</a>
    </nav>

    <div class="container">
        <?php if ($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" autocomplete="off" novalidate>
            <label for="url">Submit your issue (URL must start with <code><?= htmlspecialchars($allowed_prefix) ?></code>):</label>
            <input type="text" id="url" name="url" placeholder="<?= htmlspecialchars($allowed_prefix) ?>" required>
            <input type="submit" value="Submit to Admin">
        </form>
    </div>

    <footer>DOM-Based XSS Challenge • 2025 • T.Ko</footer>
</body>
</html>
