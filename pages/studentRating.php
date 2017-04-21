<!-- Made by Navjot on 30.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php 
            global $conn;
            $lectureId = $_POST['lectureId'];
            $lectureName = $_POST['lectureName'];
        ?>
    </head>  
    <body>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <div id="info" align="center">
            <h1>Subject: <?php echo ($lectureName) ?> </h1>
        </div>
        <div> 
            <h2>GIVE RATING</h2> 
            <center>
                <form id="rating" action="index.php?page=submitRating" onsubmit="return changeColor(this)" method="POST" target="target">
                    <input type=hidden name="lecID" value=<?php echo($lectureId) ?> > 
                    <button class="rateButton" type="submit" name="ratingValue" value="0">Very Bad</button>
                    <button class="rateButton" type="submit" name="ratingValue" value="1">Bad</button>
                    <button class="rateButton" type="submit" name="ratingValue" value="2">Average</button>
                    <button class="rateButton" type="submit" name="ratingValue" value="3">Good</button>
                    <button class="rateButton" type="submit" name="ratingValue" value="4">Very Good</button>
                </form>
            </center>
        </div>
        <iframe style="display:none;" name="target"></iframe>
    </body>
</html>
