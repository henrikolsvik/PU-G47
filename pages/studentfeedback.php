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
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script>
            function changeColor(){
                color="green";
                document.body.style.background = color;
                setTimeout(function(){ 
                    color = "white";
                    document.body.style.background = color; 
                    }, 500);
                return true;
            }
            function textEffect(){
                document.getElementById('statusSend').innerHTML = 'Feedback Sent!';
                document.getElementById('statusSend').style.color = 'green';
                setTimeout(function(){ 
                    document.getElementById('statusSend').innerHTML = 'Please submit your feedback for lecture: <?php echo($lectureName) ?>';
                    document.getElementById('statusSend').style.color = 'black';
                    }, 500);
                return true; 
            }
        </script>
    </head>
    <body>
        <h1 id="statusSend">Please submit your feedback for lecture: <?php echo($lectureName) ?></h1>
            <div id="divDifficulty" >
            <h1>How difficult do you feel the lecture is right now?</h1>
            <center>
                <form action="index.php?page=submitDifficult" onsubmit="return changeColor()" method="POST" target="target">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?> >
                    <button type="submit" name="difficultyValue" value="0"><img src="img/veryEasyRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="1"><img src="img/easyRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="2"><img src="img/okRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="3"><img src="img/hardRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="4"><img src="img/veryHardRect.png" alt="Submit"></button>
                </form>
            </center>
        </div>
        <div id="divSpeed">
            <h1>How fast do you feel the lecture is progressing right now?</h1>
            <center>
                <form action="index.php?page=submitSpeed" method="POST" target="target" onSubmit="return changeColor()">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?> >
                    <button type="submit" name="speedValue" value="0"><img src="img/verySlowRect.png" alt="Submit"></button>
                    <button type="submit" name="speedValue" value="1"><img src="img/slowRect.png" alt="Submit"></button>
                    <button type="submit" name="speedValue" value="2"><img src="img/okRect.png" alt="Submit"></button>
                    <button type="submit" name="speedValue" value="3"><img src="img/fastRect.png" alt="Submit"></button>
                    <button type="submit" name="speedValue" value="4"><img src="img/veryFastRect.png" alt="Submit"></button>
                </form>
            </center>
        </div>
        <div id="divComment">
            <h1>Do you have any comments or questions?</h1>
            <div id="divTextFieldAndButton">
                <form action="index.php?page=submitText" method="POST" target="target" onSubmit="return textEffect()">
                    <input type=hidden name="lecID" value=<?php echo($lectureID) ?>>
                    <textarea id="commmentField" name="textFeedback" rows="3" cols="30">The cat was memeing in the car.</textarea><br><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
        <iframe style="display:none;" name="target"></iframe>
    </body>
</html>
