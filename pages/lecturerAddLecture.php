<!-- Made by Navjot 23.03.2017 -->

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <?php
            global $conn;
            //getting valid lectureIDs from database
            $lecID = $_POST["lectureToFeedback"];
            $lecName = null; //Få tilsendt foreleser id fra innloggingssiden;
            $sql = "SELECT lecturerName FROM lecturer WHERE lecturerId='$lecID'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $lecName = $row["lecturerName"];
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
                    <input class="lectureField" type="text" name="lectureName" placeholder="The name of your lecture"><br>
                    <input type=hidden name="lectureToFeedback" value="<?php echo($lecName) ?>">
                    <input type=hidden name="lecturerID" value="<?php echo($lecID) ?>">
                    <input class="lectureField" type="date" name="lectureDate" placeholder="When will it be"><br>
                    <button class="aButton" type="submit" value="<?php echo($lecName) ?>">ADD LECTURE</button>
                </form>
            </div>
        </center>
    </body>
</html>