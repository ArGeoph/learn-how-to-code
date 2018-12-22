<?php 
        function parseEML($inputString) {
            //Regular expressions and corresponding html tags to replace EML tags with
            $regExpressions = array("<lesson>([\s\S]*.*?)<\/lesson>" => "<div class=\"lessonContainer\"> </div>", 
            "<chapter>([\s\S]*.*?)<\/chapter>" => "<div class=\"chapter\"> </div>", 
            "<chapterContent>([\s\S]*.*?)<\/chapterContent>" => "<p> </p>", 
            "<lessonTopic>([\s\S]*.*?)<\/lessonTopic>" => "<h3 class=\"lessonTopic\"> </h3>", 
            "<chapterTopic>([\s\S]*.*?)<\/chapterTopic>" => "<h3 class=\"chapterTopic\"> </h3>",
            "<subTopic>(.*?)<\/subTopic>" => "<h3 class=\"subTopic\"> </h3>",
            "<codeExample>" => "<div class=\"example\">", 
            "<\/codeExample>" => "</div>", 
            "<image>([\s\S]*.*?)<\/image>" => "<br><img src=\"imgURLPlaceholder\"><br>",
            "<imageCaption>([\s\S]*.*?)<\/imageCaption>" => "<figCaption> </figCaption>", 
            "<source>([\s\S]*.*?)<\/source>" => "<p class=\"source\"> </p>",
            "<listOfItems>" => "<ul>",
            "<\/listOfItems>" => "</ul>",
            "<listItem>" => "<li>",
            "<\/listItem>" => "</li>",
            "<quizQuestion>([\s\S]*.*?)<\/quizQuestion>" => "<div class=\"quizItem\"> </div>", 
            "<quizOption>([\s\S]*.*?)<\/quizOption>" => "<option> </option>", 
            "<answer>([\s\S]*.*?)<\/answer>" => "<h3 class=\"chapterTopic\"> </h3>", 
            "<answerHint>([\s\S]*.*?)<\/answerHint>" => "<h3 class=\"chapterTopic\"> </h3>");        

            $resultString = $inputString;
            foreach($regExpressions as $regExp => $replacement) {
                preg_match("/".$regExp."/", $resultString, $grabbedContent); //Get content between EML tags
                if (isset($grabbedContent[1])) { //If any content was grabbed this pass
                    if($replacement == "<br><img src=\"imgURLPlaceholder\"><br>") { //Make an exception for img tag
                        $resultString = preg_replace("/".$regExp."/", $replacement, $resultString); //Replace the whole EML tag with corresponing HTML tag
                        $resultString = preg_replace("/imgURLPlaceholder/", $grabbedContent[1], $resultString); //Insert content grabbed before in html tag
                    }
                    else {
                        $resultString = preg_replace("/".$regExp."/", $replacement, $resultString);//Replace the whole EML tag with corresponing HTML tag
                        $resultString = preg_replace("/> </", ">".$grabbedContent[1]."<", $resultString);//Insert content grabbed before in html tag
                    }

                }  
                else {
                    $resultString = preg_replace("/".$regExp."/", $replacement, $resultString); //Replace the whole EML tag with corresponing HTML tag
                }            

           }
            
            return $resultString."\n"; //Return html content with new line
        }
?>
