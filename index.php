<?php
    session_start(); //Start session: starts new session if it hasn't been created recently, or starts the session that was created on one of the previous pages
    require "helpers/utilities.php"; //Get php library checking if user is authenticated or not and change Start learning now button link based on returned value
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Learn how to code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <!-- Nav menu -->
    <nav>
        <p class="logo">Learn how to code</p>
        <div class="navButtons">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </nav>

    <!-- Main content -->  
    <main>
        <h1>Welcome to <span>Learn how to code!</span><br> Learn latest web technologies and reach your goal to become a web developer</h1>
        <a class="linkMainPage" href= "<?php echo (isUserAuthenticated() ? "lessons.php" : "login.php"); ?>"> Start learning now</a>
    </main>

    <!-- Footer -->
    <footer>
        <h3>Kirill Golubev &copy;<?php echo date('Y') ?></h3>
    </footer>
</body>
</html>