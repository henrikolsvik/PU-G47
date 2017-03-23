<!-- Made by Navjot 23.03.2017 -->

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <?php
            global $conn;
            //getting valid lectureIDs from database
            $lecID = null;
            $lecName = $_POST["lectureToFeedback"]; //Få tilsendt foreleser id fra innloggingssiden;
            $sqlID = "SELECT lecturerId FROM lecturer WHERE lecturerName='$lecName'";
            $resultID = mysqli_query($conn, $sqlID);
            while($rowID = mysqli_fetch_assoc($resultID)){
                $lecID = $rowID["lecturerId"];
            }
        ?>
    </head>
    <body>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Add a new lecture</h1>
        <h2>Lecturer: <?php echo ($lecName) ?> </h2>
        <center>
            <div id="addLecture">
                <form id="lectureForm" action="index.php?page=lecturerOverview" method="POST">
                    <input type=hidden name="lecturerID" value=<?php echo($lecID) ?>>
                    <input class="lectureField" type="text" name="textFeedback" placeholder="Let everybody know what you think!"><br>
                    <input class="aButton" type="submit" value="SEND COMMENT">
                </form>
            </div>
        </center>
    </body>
</html>