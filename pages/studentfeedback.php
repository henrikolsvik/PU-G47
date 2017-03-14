<!-- Made by Henrik on 15.02.17 --> 
 
<?php
    $lectureID = $_POST['lectureToFeedback'];
    //Using this variable to show the lecture name on the feedback site
    $lectureName = "ERROR";
    global $conn;
    //Getting lecture name using lecture id from database
    $sql = "SELECT lectureName FROM Lecture WHERE lectureId='$lectureID'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $lectureName = $row["lectureName"];
    }
    include("studentFeedbackResponse.php");
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script>
            
            //Controls how many seconds may pass between each type of feedback
            var secsBetween = 1*60000;
            var lastComment = "0"
            var lastDifficulty = "0"
            var lastSpeed = "0"


            //validation of time between feedbacks
            function feedbackControl(feedbackType){
                var currentTime = new Date();
                if(feedbackType.id == "comment"){
                    if(lastComment+secsBetween > currentTime.getTime()){
                        alert("You need to wait a bit with your comment");
                        feedbackType.action = "";
                        return 1;
                    }
                    else{
                        feedbackType.action = "index.php?page=submitText";
                        lastComment = currentTime.getTime();
                    }
                    
                }
                else if(feedbackType.id == "speed"){
                    if(lastSpeed+secsBetween > currentTime.getTime()){
                        alert("You need to wait a bit with your feedback");
                        feedbackType.action = "";
                        return 1;
                    }
                    else{
                        feedbackType.action = "index.php?page=submitSpeed";
                        lastSpeed = currentTime.getTime();
                    }
                }
                else if(feedbackType.id == "difficulty"){
                    if(lastDifficulty+secsBetween > currentTime.getTime()){
                        alert("You need to wait a bit with your feedback");
                        feedbackType.action = "";
                        return 1;
                    }
                    else{
                        feedbackType.action = "index.php?page=submitDifficult";
                        lastDifficulty = currentTime.getTime();
                    }

                }
                return 0;
            }  


            function changeColor(sender){
                var i = feedbackControl(sender);

                //skips effect to signal lack of success
                if(i == 0){
                    color="green";
                    document.body.style.background = color;
                    setTimeout(function(){ 
                        color = "#67BAB2";
                        document.body.style.background = color; 
                        }, 500);
                }
                return true;
            }

            function textEffect(sender){
                var i = feedbackControl(sender);
                
                //skips effect to signal lack of success
                if(i == 0){
                    document.getElementById('statusSend').innerHTML = 'Feedback Sent!';
                    document.getElementById('statusSend').style.color = 'green';
                    setTimeout(function(){ 
                        document.getElementById('statusSend').innerHTML = 'Please submit your feedback for lecture: <?php echo($lectureName) ?>';
                        document.getElementById('statusSend').style.color = 'black';
                    }, 500);
                }
                return true; 
            }
        </script>
    </head>
    <body> 
        <div class="logo">  
            <img src="img/ActiFeedBack.svg"> 
        </div> 
        <h1 id="statusSend">Lecture: <?php echo($lectureName) ?></h1> 
            <div class="divQuestion" > 
            <h2>HOW DIFFICULT IS THE LECTURE NOW?</h2> 
            <center>
                <form id="difficulty" action="index.php?page=submitDifficult" onsubmit="return changeColor(this)" method="POST" target="target">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?> > 
                    <input class="rateButton" type="submit" name="difficultyValue" value="0">  
                    <input class="rateButton" type="submit" name="difficultyValue" value="1"> 
                    <input class="rateButton" type="submit" name="difficultyValue" value="2"> 
                    <input class="rateButton" type="submit" name="difficultyValue" value="3"> 
                    <input class="rateButton" type="submit" name="difficultyValue" value="4"> 
                </form>
            </center>
        </div>
        <div class="divQuestion">  
            <h2>HOW FAST IS THE LECTURE PROGRESSING?</h2> 
            <center>
                <form id="speed" action="index.php?page=submitSpeed" method="POST" target="target" onSubmit="return changeColor(this)">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?> >    
                    <input class="rateButton" type="submit" name="speedValue" value="0"> 
                    <input class="rateButton" type="submit" name="speedValue" value="1"> 
                    <input class="rateButton" type="submit" name="speedValue" value="2"> 
                    <input class="rateButton" type="submit" name="speedValue" value="3"> 
                    <input class="rateButton"type="submit" name="speedValue" value="4"> 
                </form>
            </center>
        </div>
        <div class="divQuestion"> 
            <h2>DO YOU HAVE ANY COMMENTS?</h2> 
            <div id="divComment"> 
                <form id="comment" action="index.php?page=submitText" method="POST" target="target" onSubmit="return textEffect(this)">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?>> 
                    <center>
                    <input class="commentField" type="text" name="textFeedback" placeholder="Comment..."><br>
                    <input class="aButton" type="submit" value="SEND COMMENT">
                    </center>
                </form>
            </div>
        </div>
        <iframe style="display:none;" name="target"></iframe>
    </body>
</html>
