<!-- public/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS DOM Based - Introduction</title>
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

        h1 {
            color: #2c3e50;
            font-size: 2.2rem;
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            width: 80%;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        #state {
            margin-top: 15px;
            font-weight: bold;
        }

        footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Are you lucky?</h1>
    <nav>
        <a href="index.php">Main</a> |
        <a href="contact.php">Contact</a>
    </nav>

    <div class="container">
        <p>Choose a number between <strong>0 and 100</strong></p>
        <form action="" method="get">
            <input type="text" name="number" placeholder="Your lucky number">
            <br>
            <input type="submit" value="Submit">
        </form>
        <div id="state"></div>
    </div>

    <footer>DOM-Based XSS Challenge • 2025 • T.Ko</footer>

<?php
$number = isset($_GET['number']) ? $_GET['number'] : '';
?>


</body>
</html>


















															
															<script>
                                                                var guess = '<?php echo htmlspecialchars($number, ENT_QUOTES); ?>';  // Initialize guess variable
    														var number = '<?php echo $number; ?>';

    																	if (guess !== '' && number !== '') {
        												var random = Math.floor(Math.random() * 100);
        															if (guess == random) {
            											document.getElementById("state").style.color = "green";
            							document.getElementById("state").innerHTML = "🎉 You won this game, but no flag here ;)";
        																} else {
            											document.getElementById("state").style.color = "red";
            						document.getElementById("state").innerHTML = "❌ Wrong answer! The right answer was " + random;
        																	}
    																		}
																		</script>																																							
