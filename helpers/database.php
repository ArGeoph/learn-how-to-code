<?php  
    //=============================================================================//
    //***PHP Code ***/

    //Get 10 most popular bookmarks from database
    // $tenMostPopularBookmars;

    // function getBookmarks() {
    //     $dbConnection = connectToDB();

    //     //get all bookmarks for the this particular user
    //     $requestBookmarks = "SELECT name, url, COUNT(url) AS number_of_entries FROM bookmarks GROUP BY url ORDER BY number_of_entries DESC LIMIT 10";
    //     $GLOBALS["tenMostPopularBookmars"] = mysqli_query($dbConnection, $requestBookmarks);

    //     mysqli_close($dbConnection);
    // }

    //Function checking if user entered correct user and password on the login page
    function authenticateUser() {
        //get database connection handler 
        $dbConnection = connectToDB();

        $query = "SELECT userID FROM users WHERE log =" . "\"". $GLOBALS["login"] . "\"";
        //Check if there's such login in the database
        $result = mysqli_query($dbConnection, $query);

        if (mysqli_num_rows($result) > 0) {
            //if we are here such a login exists in the database, so now we can check password
            $queryPassword = "SELECT pass FROM users WHERE log =" . "\"". $GLOBALS["login"] . "\"";
            $passwordResult = mysqli_query($dbConnection, $queryPassword);
            $row = mysqli_fetch_assoc($passwordResult);
            
            if (password_verify($GLOBALS["pass"], $row["pass"])) {
               
                $_SESSION["authenticated"] = true;
                $_SESSION["login"] = $GLOBALS["login"];
                $_SESSION["userID"] = mysqli_fetch_assoc($result)["userID"];
                header("Location: http://127.0.0.1/tma2/part2/app/loged.php"); //If user entered correct password and login, redirect them to paige with learning content
                exit();
            }
            else {
                $GLOBALS["logErrorMessages"]["passError"] = "* Password incorrect. Try again";
                $GLOBALS["pass"] = "";
            }
        }
        else {
            $GLOBALS["logErrorMessages"]["logError"] = "* Login doesn't exist";
        }

        mysqli_close($dbConnection);
    }


    //Create user and write everything to database 
    function createUser() {
        $dbConnection = connectToDB();

        $query = "INSERT INTO users (email, log, pass) VALUES (" . "\"" .  $GLOBALS["email"] . "\"" .  "," . "\"" . $GLOBALS["login"] . "\"" . "," 
        . "\"" . password_hash($GLOBALS["password1"], PASSWORD_BCRYPT) . "\")";

        $result = mysqli_query($dbConnection, $query);

        if ($result) {
            echo "User created";
            header ("Location:  http://127.0.0.1/tma2/part2/app/success.php");
            exit();
        }
        else {
            echo "Error adding user, try later";
        }

        mysqli_close($dbConnection);
    }

    //Function checking if email has been already used and it's in database
    function emailIsUsed($email) {
        $dbConnection = connectToDB();

        $sqlQuery = "SELECT userID FROM users WHERE email = \"" . $email . "\"" ;
        $result = mysqli_query($dbConnection, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            return true;
        }
        else {
            return false;
        }

        mysqli_close($dbConnection);
    }

    //Function checking if login has been already used and it's in database
    function loginIsUsed($login) {
        $dbConnection = connectToDB();

        $sqlQuery = "SELECT userID FROM users WHERE log = \"" . $login . "\"";
        $result = mysqli_query($dbConnection, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            return true;
        }
        else {
            return false;
        }

        mysqli_close($dbConnection);
    }

    //Get learning content from database
    function getLearningContent() {
        $dbConnection = connectToDB();
        mysqli_select_db($dbConnection, "bookmarks");

        //get all bookmarks for the this particular user
        $requestBookmarks = "SELECT * FROM bookmarks WHERE userID = \""  .$_SESSION["userID"] . "\"";
        $requestResult = mysqli_query($dbConnection, $requestBookmarks);
        mysqli_close($dbConnection);

        return $requestResult;
    }

    //Function connecting to database and returning database handler
    function connectToDB() {
        $dbConnection = mysqli_connect("localhost", "testUser", "GHNKCh3hgmpdE3Ka"); //Connect to MySQL

        if (!$dbConnection) {
            echo "Error connecting to db";
            die ("Couldn't connect to database. Try later or check your credentials");
        }
        else {
            mysqli_select_db($dbConnection, "learnHowToCode"); //Select requrired database
            echo "Success";
        }
        return $dbConnection;
    }  
    //=============================================================================//
    //***PHP Code Ends***/   
?>