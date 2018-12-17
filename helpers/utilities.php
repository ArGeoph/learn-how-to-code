<?php  

    //Function checking user input to prevent attacks on the website
    function checkUserInput($userInput) {
        $userInput = trim($userInput);
        $userInput = stripcslashes($userInput);
        $userInput = htmlspecialchars($userInput);

        return $userInput;
    }

    //Check if all input fields were filled
    function isAllFieldsAreFilled() {
        //iterate through error array to see if there's any errors 
        foreach ($GLOBALS["logErrorMessages"] as $error) {
            if ($error != "") {
                return false;
            }
        }

        return true;
    }

    //Check if user is authenticated or not
    function isUserAuthenticated() {

        if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {
            return true;
        }
        else {
           return false; 
        }    
    }

    //Function printing current year
    function printYear() {
        echo date('Y');
    }
?>