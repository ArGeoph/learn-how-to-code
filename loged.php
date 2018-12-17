<?php  
    //=============================================================================//
    //***PHP Code ***/
    session_start(); 

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
   
    //Check if any form button was pressed
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["newUrlName"]) && isset($_POST["newUrl"])) {
            insertNewBookmarkToDatabase();            
        }
        
        //Check if remove button was pressed
        if (isset($_POST["removeBookmark"])) {
            removeBookmarkFromDatabase($_POST["removeBookmark"]);
        }

        //Check if user button to update bookmark
        if (isset($_POST["updateBookmark"])) {
            updateBookmarkInDatabase($_POST["updateBookmark"]);
           
        }

        $_POST = array();   
        unset($_REQUEST);
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
            <a href="logout.php">Logout</a>
        </div>
    </nav>
        
    <main>
        <div class="bookmarksContainer"> 
            <h1>Welcome <?php echo $_SESSION["login"]; ?>!</h1>          

            <?php  
            //=============================================================================//
            //***PHP Code ***/

            $bookmarks = getBookmarks(); //Get user bookmarks from database

            if (mysqli_num_rows(($bookmarks)) > 0) {
                echo "<h3>Your bookmarks</h3><ul><form id=\"bookmarkForm\" name=\"theForm\" action=\"loged.php\" method=\"POST\">";
                echo "<li><p class='userPage'><label>Website name</label><label>Web address</label></p></li>";
                while ($row = mysqli_fetch_assoc($bookmarks)) {
                                    
                    echo ("<li><input type=\"text\" name=\"linkName" . $row["bookmarkID"] . "\" class=\"bookmarkFiels\" value=\"" . $row["name"] . "\"  disabled  formaction=\"loged.php\" />");
    
                    echo ("<input type=\"text\" name=\"linkUrl" . $row["bookmarkID"] . "\" class=\"bookmarkFiels urlField\" value=\"" . $row["url"] . "\"  disabled  formaction=\"loged.php\" />");
                    echo ("<a class=\"bookmarkButton\" href=\"" . $row["url"] . "\" target=\"_blank\">Open &#8594;</a>");
                    echo ("<button class=\"bookmarkButton\" type=\"submit\" value=\"" . $row["bookmarkID"] . "\" name=\"removeBookmark\" formaction=\"loged.php\">Remove</button>");
                    echo ("<button class=\"bookmarkButton  editButton\" type=\"button\" name=\"updateBookmark\" value=\"" . $row["bookmarkID"] . "\" formaction=\"loged.php\">Edit</button>");
                    echo ("<button class=\"bookmarkButton  saveButton hidden\" type=\"submit\" name=\"updateBookmark\" value=\"" . $row["bookmarkID"] . "\" formaction=\"loged.php\">Save</button>");
                    echo ("<button class=\"bookmarkButton cancelButton hidden\" value=\"" . $row["bookmarkID"] . "\" formaction=\"loged.php\">Cancel</button>");
                }
                echo "</form></ul>";

            }
            else {
                
                echo "<h3>You don't have any bookmarks, but you can add some</h3>";
                echo "<form id=\"bookmarkForm\" action=\"loged.php\" method=\"POST\">";
                echo "</form></ul>";
            }
            //=============================================================================//
            //***PHP Code Ends ***/
            ?>
            <button class="bookmarkButton addNewBookmark" id="addBookmark">Add new bookmark</button>
        </div>
    </main>

    <footer>
        <h3>Kirill Golubev &copy;<?php echo date('Y') ?></h3>
    </footer>
</body>
</html>