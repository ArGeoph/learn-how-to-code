<?php  
    //=============================================================================//
    //***PHP Code ***/
    session_start(); //Start session: starts new session if it hasn't been created recently, or starts the session that was created on one of the previous pages
    require "helpers/utilities.php"; //Get php library checking if user is authenticated or not and change Start learning now button link based on returned value
    require "helpers/parser.php";
    require "helpers/database.php";
    $content;  //Variable will be used to store content

    //Check if user authenticated
    if(!isUserAuthenticated()) {
        header("Location: login.php");
        exit();
    }

    //Get number of lessons and quizzes in database
    $numberOfLessons = getNumberOfLessons();
    $numberOfQuizzes = getNumberOfQuizzes();

    //Check if any button in the menu was pressed
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        //Check if user wants to render lesson content
        if(isset($_POST["lesson"])) {
            $content = parseEML(getLearningContent($_POST["lesson"]));//Parse and render lesson content
        }   

        if(isset($_POST["quiz"])) {
            $content = parseEML(getQuizzesContent($_POST["quiz"]));
        }
    }    
    //=============================================================================//
    //***PHP Code Ends***/   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Learn how to code. Loged</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
    <!-- Nav menu -->
    <nav>
    <p class="logo">Learn how to code</p>
        <div class="navButtons">
            <a href="index.php"><button>Main</button></a>
            <?php 
                //Get number of lessons and create nav menu according to that
                if (mysqli_num_rows($numberOfLessons) > 0 && mysqli_num_rows($numberOfLessons) < 3) {
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($numberOfLessons)) {
                        echo "<a><button type=\"submit\" name=\"lesson\" value=\"" .$row["lessonID"]. "\">Lesson$counter</button></a>"; 
                        $counter++;
                    }                    
                }
                else if (mysqli_num_rows($numberOfLessons) > 2) {
                    echo "<div class=\"dropdownMenu\">
                            <button class=\"dropDownTitle\">Lessons</button><div class=\"dropdownItems\"><form action=\"loged.php\" method=\"POST\">";

                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($numberOfLessons)) {
                        echo "<button type=\"submit\" formaction=\"loged.php\" method=\"POST\" name=\"lesson\" value=\"" .$row["lessonID"]. "\">Lesson$counter</button>"; 
                        $counter++;
                    }
                    echo "</form></div></div>";
                }  
                
                //Get number of quizzes and create nav menu according to that
                if (mysqli_num_rows($numberOfQuizzes) > 0 && mysqli_num_rows($numberOfQuizzes) < 3) {
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($numberOfQuizzes)) {
                        echo "<a><button type=\"submit\" name=\"quiz\" value=\"" .$row["lessonID"]. "\">Quiz$counter</button></a>"; 
                        $counter++;
                    }                    
                }
                else if (mysqli_num_rows($numberOfQuizzes) > 2) {
                    echo "<div class=\"dropdownMenu\">
                            <button class=\"dropDownTitle\">Quizzes</button><div class=\"dropdownItems\"><form action=\"loged.php\" method=\"POST\">";

                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($numberOfQuizzes)) {
                        echo "<button type=\"submit\" formaction=\"loged.php\" method=\"POST\" name=\"quiz\" value=\"" .$row["lessonID"]. "\">Quiz$counter</button>"; 
                        $counter++;
                    }
                    echo "</form></div></div>";
                }  
            ?> 
            <a href="logout.php"><button>Logout</button></a>
        </div>
    </nav>
        
    <main>
          

            <?php  
            //=============================================================================//
            //***PHP Code ***/

            if (isset($content)) {
                echo($content);
            }
            else {
                echo "<h1>Welcome " .$_SESSION["login"]. "!</h1>";         
                if (mysqli_num_rows(($numberOfLessons)) > 0) {
              
                    echo "<h3>Please select one of ". mysqli_num_rows(($numberOfLessons)). " lessons and one of " .mysqli_num_rows($numberOfQuizzes).
                    " quizzes in menu bar</h3>";
    
                }
                else {
                    
                    echo "<h3>There has been no any educational content added so far, but there will be added some soon</h3>";
                }
            }

            //=============================================================================//
            //***PHP Code Ends ***/
            ?>
    </main>

    <footer>
        <h3>Kirill Golubev &copy;<?php echo date('Y') ?></h3>
    </footer>
</body>
</html>