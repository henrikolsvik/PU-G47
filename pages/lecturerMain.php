<!-- Made by Helene on 28.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php
            //updates the rating of this lecture, this is run when a lecture is finished
            if (isset($_POST['avgRating'])) {
                $avgRating = (int)($_POST['avgRating']);
                $lectureIDToSet = ($_POST['lectureId']);
                //Getting the table from the DB
                global $conn;
                $sql = "UPDATE Lecture
                        SET lectureRating=$avgRating, ratingActive=0
                        WHERE lectureId=$lectureIDToSet";
                mysqli_query($conn, $sql);
            }

            global $conn;
            //getting currently logged in lecturerID
            $lecID = null;
            $lecName = $_POST["lectureToFeedback"];
            $sqlID = "SELECT lecturerId FROM lecturer WHERE lecturerName='$lecName'";
            $resultID = mysqli_query($conn, $sqlID);
            while($rowID = mysqli_fetch_assoc($resultID)){
                $lecID = $rowID["lecturerId"];
            }
            $lectureId = null;
            //selects only active lectures which the students can enter
            $sqlLectureId = "SELECT lectureId FROM lecture WHERE lecturerId=$lecID AND (feedbackActive=1 OR ratingActive=1)";
            $resultLectureId = mysqli_query($conn, $sqlLectureId);
            while($rowLectureId = mysqli_fetch_assoc($resultLectureId)){
                $lectureId = $rowLectureId["lectureId"];
            }
            if ($lectureId == null) { $lectureId = -1; }
        ?>
    </head>
    <body>
        <div align="left" id="menuButton">
            <form id="log_out" action="index.php?page=mainPage" method="POST">
                <button class="bButton" type="submit">LOG OUT</button>
            </form>
        </div>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Lecturer: <?php echo ($lecName) ?> </h1>
        <center>
            <form id="continueLecture" action="index.php?page=lecturerFeedback" method="POST">
                <input type=hidden name="lectureId" value="<?php echo($lectureId) ?>">
                <button class="aButton" id="activeButton" name="lectureToFeedback" value="<?php echo($lecName) ?>" type="submit">ACTIVE LECTURE</button>
            </form>
            <form id="newLecture" action="index.php?page=lecturerAddLecture" method="POST">
                <button class="aButton" id="newButton" name="lectureToFeedback" value="<?php echo($lecID) ?>" type="submit">NEW LECTURE</button>
            </form>
            <form id="statistics" action="index.php?page=lecturerOverview" method="POST">
                <button class="aButton" name="lectureToFeedback" value="<?php echo($lecName) ?>" type="submit">STATISTICS</button>
            </form>
        </center>
        <script>
            //the lecturer can only have one active lecture at a given time
            var lectureId = null;
            lectureId = <?php echo($lectureId); ?>;
            if (lectureId > -1) {
                document.getElementById('newButton').disabled = true;
            } else {
                document.getElementById('activeButton').disabled = true;
            }
        </script>
    </body>
</html>

