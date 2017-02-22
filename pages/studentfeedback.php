<!-- Made by Henrik on 15.02.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <h1>Welcome</h1>
        <div id="divDifficulty" >
            <h1>How difficult do you feel the lecture is right now?</h1>
            <center>
                <form action="index.php?page=submitDifficult" method="POST">
                    <button type="submit" name="difficultyValue" value="0"><img src="img/verySlowRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="1"><img src="img/slowRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="2"><img src="img/okRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="3"><img src="img/fastRect.png" alt="Submit"></button>
                    <button type="submit" name="difficultyValue" value="4"><img src="img/veryFastRect.png" alt="Submit"></button>
                </form>
            </center>
        </div>
        <div id="divSpeed">
            <h1>How fast do you feel the lecture is progressing right now?</h1>
            <center>
                <form action="index.php?page=submitSpeed" method="POST">
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
                <form action="index.php?page=submitText" method="POST" target="target">
                    <textarea name="textFeedback" rows="3" cols="30">The cat was playing in the garden.</textarea><br><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
        <iframe style="display:none;" name="target"></iframe>
    </body>
</html>
