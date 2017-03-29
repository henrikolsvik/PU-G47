<!-- Made by Helene on 28.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
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
        <h1>Lecturer: <?php echo ($lecName) ?> </h1>
        <center>
            <form id="addLecture" action="index.php?page=lecturerAddLecture" method="POST">
                <button class="aButton" name="lectureToFeedback" value="<?php echo($lecID) ?>" type="submit">NEW LECTURE</button>

            </form>
            <form id="addLecture" action="index.php?page=lecturerOverview" method="POST">
                <button class="aButton" name="lectureToFeedback" value="<?php echo($lecName) ?>" type="submit">STATISTICS</button>

            </form>
        </center>
    </body>
</html>

