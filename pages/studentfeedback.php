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
        <script type="text/javascript" src="js/studentFeedbackController.js"></script>
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
                    <button class="rateButton" type="submit" name="difficultyValue" value="0">Very Difficult</button>
                    <button class="rateButton" type="submit" name="difficultyValue" value="1">Difficult</button>
                    <button class="rateButton" type="submit" name="difficultyValue" value="2">Medium</button>
                    <button class="rateButton" type="submit" name="difficultyValue" value="3">Easy</button>
                    <button class="rateButton" type="submit" name="difficultyValue" value="4">Very Easy</button>
                </form>
            </center>
        </div>
        <div class="divQuestion">  
            <h2>HOW FAST IS THE LECTURE PROGRESSING?</h2> 
            <center>
                <form id="speed" action="index.php?page=submitSpeed" method="POST" target="target" onSubmit="return changeColor(this)">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?> >    
                    <button class="rateButton" type="submit" name="speedValue" value="0">Very Slow</button>
                    <button class="rateButton" type="submit" name="speedValue" value="1">Slow</button>
                    <button class="rateButton" type="submit" name="speedValue" value="2">Medium</button>
                    <button class="rateButton" type="submit" name="speedValue" value="3">Fast</button>
                    <button class="rateButton" type="submit" name="speedValue" value="4">Very Fast</button>
                </form>
            </center>
        </div>
        <div class="divQuestion"> 
            <h2>DO YOU HAVE ANY COMMENTS?</h2> 
            <div id="divComment"> 
                <form id="comment" action="index.php?page=submitText" method="POST" target="target" onSubmit="return changeColor(this)">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?>> 
                    <center>
                    <input class="commentField" type="text" name="textFeedback" placeholder="Let the lecturer know what you think!"><br>
                    <input class="aButton" type="submit" value="SEND COMMENT">
                    </center>
                </form>
            </div>
        </div>
        <iframe style="display:none;" name="target"></iframe>
    </body>
</html>
