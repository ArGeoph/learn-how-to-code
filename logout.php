<?php
    //Remove sesion 
    session_start();
    session_unset();
    session_destroy();
    
    //Redirect user to main page
    header("Location: http://127.0.0.1/tma2/part2/app/index.php");
?>