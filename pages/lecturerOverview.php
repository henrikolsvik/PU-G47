<!-- Made by Helene on 14.03.17 --> 

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
            
            $sql = "SELECT lectureId, lectureName, lectureDate, lectureRating, lectureAvgSpeed, lectureAvgDifficulty FROM Lecture WHERE lecturerId='$lecID'";
            $result = mysqli_query($conn, $sql);
            $numOfLectures = 0;

            //Show error if there are no data in the table
            if (!$result) {
                echo(mysqli_error($conn));
            } else {
                //Print out data using while loop
                $stack = array();
                while($row = mysqli_fetch_assoc($result)) {
                    $numOfLectures++;
                    array_push($stack, [$row["lectureId"],$row["lectureDate"],$row["lectureName"],$row["lectureAvgSpeed"],$row["lectureAvgDifficulty"],$row["lectureRating"]]);
                }
            }

            if ((isset($_POST['lectureName'])) && (isset($_POST['lectureDate']))) {
                $lectureName = $_POST['lectureName'];
                $lecturerId = $_POST['lecturerID'];
                $lectureDate = $_POST['lectureDate'];

                $sql = "INSERT INTO Lecture (lectureName, lecturerId, lectureRating, lectureAvgSpeed, lectureAvgDifficulty, lectureDate)
                VALUES ('$lectureName', '$lecturerId', 0, 0, 0, '$lectureDate')";

                if (mysqli_query($conn, $sql)) {
                    echo('<script type="text/javascript">alert("Success, you may refresh");</script>');
                } else {
                    echo('<script type="text/javascript">alert("Failed");</script>');
                }
            }
        ?>
    </head>
    <body> 
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Feedback from previous lectures</h1>
        <h2>Lecturer: <?php echo ($lecName) ?> </h2>
        <table class="tg" style="margin: 0px auto;">
            <tr>
                <th class="tg-zd1f">Id</th>
                <th class="tg-zd1f">Date</th>
                <th class="tg-zd1f">Course name</th>
                <th class="tg-zd1f">Average speed<br>(slow 0-5 fast)</th>
                <th class="tg-zd1f">Average difficulty<br>(easy 0-5 hard)</th>
                <th class="tg-zd1f">Total rating<br>(bad 0-5 good)</th>
                <th class="tg-zd1f">Link to lecture</th>
            </tr>
            <?php
                for ($i = 0; $i < $numOfLectures; $i++) {
                    echo("<tr>" );
                    for ($j = 0; $j < 6; $j++) {
                        echo("<th class='tg-yw4l'>".$stack[$i][$j]."</th>");
                    }
                    echo('<th class="tg-yw41">');
                    echo('<div id="enter"><form id="enterLecture" action="index.php?page=lecturerFeedback" method="POST">');
                    echo('<input type="hidden" name="lectureDate" value="'.$stack[$i][1].'"/>');
                    echo('<button class="lectureButton" name="lectureToFeedback" value="'.$lecName.'" type="submit">ENTER</button>');
                    echo("</form></div></th></tr>");
                }
            ?>
        </table>
        <center>
            <form id="addLecture" action="index.php?page=lecturerAddLecture" method="POST">
                <button class="aButton" name="lectureToFeedback" value="<?php echo($lecID) ?>" type="submit">ADD LECTURE</button>
            </form>
        </center>
    </body>
</html>

