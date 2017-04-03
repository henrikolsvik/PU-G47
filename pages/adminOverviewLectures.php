<!-- Made by Navjot on 23.03.2017 -->

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <?php
            global $conn;
            //getting valid lectureIDs from database
            $lecturerId = $_POST["lecturerId"];

            $lecID = null;
            $lecName = $_POST["lectureToFeedback"]; //Få tilsendt foreleser id fra innloggingssiden;
            $sqlLID = "SELECT lecturerId FROM lecturer WHERE lecturerName='$lecturerId'";
            $resultLID = mysqli_query($conn, $sqlLID);
            while($rowLID = mysqli_fetch_assoc($resultLID)){
                $lecturerId = $rowLID["lecturerId"];
            }
            $sqlID = "SELECT lecturerId FROM lecturer WHERE lecturerName='$lecName'";
            $resultID = mysqli_query($conn, $sqlID);
            while($rowID = mysqli_fetch_assoc($resultID)){
                $lecID = $rowID["lecturerId"];
            }
            
            $sql = "SELECT lectureDate, lectureName, lectureRating FROM Lecturer JOIN Lecture ON Lecturer.lecturerId = Lecture.lecturerId WHERE Lecturer.lecturerId=$lecturerId";
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
                    array_push($stack, [$row["lectureDate"],$row["lectureName"],$row["lectureRating"]]);
                }
            }
        ?>
    </head>
    <body>
        <div align="left" id="menuButton">
            <form id="log_out" action="index.php?page=mainPage" method="POST">
                <button class="bButton" type="submit">LOG OUT</button>
            </form>
            <form id="menu" action="index.php?page=adminOverview" method="POST">
                <button class="bButton" name="lectureToFeedback" value="<?php echo($lecName) ?>" type="submit">BACK</button>
            </form>
        </div>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Lecturer ratings</h1>
        <h2>Lecturer: <?php echo ($_POST["lecturerId"]) ?> </h2>
        <table class="tg" style="margin: 0px auto;">
            <tr>
                <th class="tg-zd1f">Lecture date</th>
                <th class="tg-zd1f">Lecture name</th>
                <th class="tg-zd1f">Lecture rating</th>
            </tr>
            <?php
                $old = "";
                for ($i = 0; $i < $numOfLectures; $i++) {
                    echo("<tr>");
                    for ($j = 0; $j < 3; $j++) {
                        echo("<th class='tg-yw4l'>".$stack[$i][$j]."</th>");
                    }
                    echo("</tr>");
                }
            ?>
        </table>
    </body>
</html>