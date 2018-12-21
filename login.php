<?php
    session_start(); 
    require "helpers/utilities.php"; 
    require "helpers/database.php";
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

    <?php 
        $logErrorMessages = array ("logError" => "", "passError" => ""); //Array with error messages 
        $login = $pass = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Check if fields are not empty
            if ($_POST["login"] == "") {
                $logErrorMessages["logError"] = "* Login field cannot be empty";
            }
            else {
                $login = checkUserInput($_POST["login"]);
            }

            if ($_POST["pass"] == "") {
                $logErrorMessages["passError"] = "* Password field cannot be empty";
            }
            else {
                $pass = checkUserInput($_POST["pass"]);
            }

            if(isAllFieldsAreFilled()) { //If all fields are filled called function checking if the login and password exist
                authenticateUser();
            }
        }   

    ?>

    <!-- HTML content -->
    <!-- Nav menu -->
    <nav>
    <p class="logo">Learn how to code</p>
        <div class="navButtons">
            <a href="index.php"><button>Main</button></a>
            <a href="register.php"><button>Register</button></a>
        </div>
    </nav>
        
    <main>
        <div class="loginContainer"> 
            <h1>Login</h1>   
            <form action="login.php" class="loginForm" method="POST" autocomplete="off" >
                <input type="password" style="display:none">
                <label>Login</label><input type="text" class="formFields" name="login" value="<?php echo $login ?>"/>
                <span class="error"><?php echo $logErrorMessages["logError"]; ?></span><br>
                <label>Password</label><input type="password" class="formFields" name="pass" value=""  />
                <span class="error"><?php echo $logErrorMessages["passError"]; ?></span>
                <div class="buttonsContainer">
                    <input type="submit" class="formButton" value="Submit"/>
                    <input type="reset" class="formButton"  value="Clear fields" />
                </div>
            </form>      
        </div>
    </main>

    <footer>
        <h3>Kirill Golubev &copy;<?php printYear(); ?></h3>
    </footer>
</body>
</html>