<!-- Made by Helene on 28.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head>
    <body> 
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>navnet til foreleser</h1> <!--- TODO: Sett inn php med navnet til foreleser -->
        <center>
            <form id="addLecture" action="index.php?page=lecturerAddLecture" method="POST">
                <button class="aButton" name="lectureToFeedback" value="<?php echo($lecID) ?>" type="submit">NEW LECTURE</button>

            </form>
            <form id="addLecture" action="index.php?page=lecturerOverview" method="POST">
                <button class="aButton" name="lectureToFeedback" value="<?php echo($lecID) ?>" type="submit">STATISTICS</button>

            </form>
        </center>
    </body>
</html>

