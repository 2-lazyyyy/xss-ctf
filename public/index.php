<!-- public/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS DOM Based - Introduction</title>
</head>
<body>
    <h1>Are you lucky?</h1>
    <p><a href="index.php">Main</a> | <a href="contact.php">Contact</a></p>
    <hr>
    <p>Choose a number between 0 and 100</p>
    <form action="" method="get">
        <input type="text" name="number" placeholder="Number">
        <input type="submit" value="Submit">
    </form>
    <br>
    <div id="state"></div>
</body>

<script>
    var number = new URLSearchParams(window.location.search).get("number");
    var random = Math.floor(Math.random() * 100);
    if (number == random) {
        document.getElementById("state").style.color = "green";
        document.getElementById("state").innerHTML = "You won this game, but no flag here ;)";
    } else {
        document.getElementById("state").style.color = "red";
        document.getElementById("state").innerHTML = "Wrong answer! The right answer was " + random;
    }
</script>
</html>
