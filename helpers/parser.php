<?php 
        $testString = "<lesson>
            <chapter>
		        <chapterTopic>Asyncronous requests</chapterTopic>
		            <chapterContent>Asyncronous requests provide better user experience
			            <image>www.example.com/123.jpeg </image>
				        <imageCaption>Picture caption</imageCaption>					
		            </chapterContent>
            </chapter>
        </lesson>";


        // echo parseEML($testString);

        function parseEML($inputString) {
            //Regular expressions and corresponding html tags to replace EML tags with
            $regExpressions = array("<lesson>([\s\S]*.*?)<\/lesson>" => "<div class=\"lesson\"> </div>", 
            "<chapter>([\s\S]*.*?)<\/chapter>" => "<div class=\"chapter\"> </div>", 
            "<chapterContent>([\s\S]*.*?)<\/chapterContent>" => "<div class=\"chapterContent\"> </div>", 
            "<lessonTopic>([\s\S]*.*?)<\/lessonTopic>" => "<h3 class=\"lessonTopic\"> </h3>", 
            "<chapterTopic>([\s\S]*.*?)<\/chapterTopic>" => "<h3 class=\"chapterTopic\"> </h3>",
            "<codeExample>([\s\S]*.*?)<\/codeExample>" => "<p class=\"codeExample\"> </p>", 
            "<image>([\s\S]*.*?)<\/image>" => "<img src=\"imgURLPlaceholder\">",
            "<imageCaption>([\s\S]*.*?)<\/imageCaption>" => "<figCaption> </figCaption>", 
            "<quizItem>([\s\S]*.*?)<\/quizItem>" => "<div class=\"quizItem\"> </div>",
            "<quizQuestion>([\s\S]*.*?)<\/quizQuestion>" => "<div class=\"quizItem\"> </div>", 
            "<quizOption>([\s\S]*.*?)<\/quizOption>" => "<option> </option>", 
            "<answer>([\s\S]*.*?)<\/answer>" => "<h3 class=\"chapterTopic\"> </h3>", 
            "<answerHint>([\s\S]*.*?)<\/answerHint>" => "<h3 class=\"chapterTopic\"> </h3>");
            
            
            $resultString = $inputString;
            foreach($regExpressions as $regExp => $replacement) {
                preg_match("/".$regExp."/", $resultString, $grabbedContent); //Get content between EML tags
                if (isset($grabbedContent[1])) { //If any content was grabbed this pass
                    if($replacement == "<img src=\"imgURLPlaceholder\">") { //Make an exception for img tag
                        $resultString = preg_replace("/".$regExp."/", $replacement, $resultString); //Replace the whole EML tag with corresponing HTML tag
                        $resultString = preg_replace("/imgURLPlaceholder/", $grabbedContent[1], $resultString); //Insert content grabbed before in html tag
                    }
                    else {
                        $resultString = preg_replace("/".$regExp."/", $replacement, $resultString);//Replace the whole EML tag with corresponing HTML tag
                        $resultString = preg_replace("/> </", ">".$grabbedContent[1]."<", $resultString);//Insert content grabbed before in html tag
                    }

                }              

           }
            
            return $resultString."\n"; //Return html content with new line
        }
?>
