<!-- Made by Henrik on 15.02.17 --> 
 
<?php
    $lectureID = $_POST['lectureToFeedback'];
    //Using this variable to show the lecture name on the feedback site
    $lectureName = "ERROR";
    $feedbackActive = null;
    $ratingActive = null;    
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
        <script>
            function checkActive() {
                <?php
                    $sql = "SELECT feedbackActive, ratingActive FROM Lecture WHERE lectureId='$lectureID'";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)) {
                        $feedbackActive = $row["feedbackActive"];
                        $ratingActive = $row["ratingActive"];
                    }
                ?>
                var feedbackActive = "<?php echo $feedbackActive ?>";
                var ratingActive = "<?php echo $ratingActive ?>";
                if (feedbackActive == 0) {
                    document.getElementById("divQuestion").style.visibility = "hidden";
                    document.getElementById("divRating").style.visibility = "visible";
                }
                if(feedbackActive == 0 && ratingActive == 0) {
                    document.getElementById("exit").submit();
                }
            }
            window.setInterval(function(){checkActive();}, 2000);
        </script>
    </head>
    <body>
        <div align="left" id="menuButton">
            <form id="exit" action="index.php?page=mainPage" method="POST">
                <button class="bButton" type="submit">EXIT</button>
            </form>
        </div>
        <div class="logo">  
            <img src="img/ActiFeedBack.svg"> 
        </div> 
        <h1 id="statusSend">Lecture: <?php echo($lectureName) ?></h1>
        <div id="main">
            <div id="feedback">
                <div id="divQuestion" > 
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
                    <h2>HOW FAST IS THE LECTURE PROGRESSING?</h2> 
                    <center>
                        <form id="speed" action="index.php?page=submitSpeed" method="POST" target="target" onSubmit="return changeColor(this)">
                            <input type=hidden name="lecID" value=<?php echo($lectureID) ?> >    
                            <button class="rateButton" type="submit" name="speedValue" value="0">Too Slow</button>
                            <button class="rateButton" type="submit" name="speedValue" value="1">Slow</button>
                            <button class="rateButton" type="submit" name="speedValue" value="2">Medium</button>
                            <button class="rateButton" type="submit" name="speedValue" value="3">Fast</button>
                            <button class="rateButton" type="submit" name="speedValue" value="4">Too Fast</button>
                        </form>
                    </center>
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
            </div>
            <iframe style="display:none;" name="target"></iframe>
            <div id="divRating">
                <h2>GIVE RATING</h2> 
                <center>
                    <form id="rating" action="index.php?page=submitRating" onsubmit="return changeColor(this)" method="POST" target="target">
                        <input type=hidden name="lecID" value=<?php echo($lectureID) ?> > 
                        <button class="rateButton" type="submit" name="ratingValue" value="0">Very Bad</button>
                        <button class="rateButton" type="submit" name="ratingValue" value="1">Bad</button>
                        <button class="rateButton" type="submit" name="ratingValue" value="2">Average</button>
                        <button class="rateButton" type="submit" name="ratingValue" value="3">Good</button>
                        <button class="rateButton" type="submit" name="ratingValue" value="4">Very Good</button>
                    </form>
                </center>
            </div>
        </div>
    </body>
</html>
