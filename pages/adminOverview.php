<!-- Made by Navjot on 23.03.2017 -->

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
            
            $sql = "SELECT lecturerName, lectureDate, lectureName, lectureRating FROM Lecturer JOIN Lecture ON Lecturer.lecturerId = Lecture.lecturerId";
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
                    array_push($stack, [$row["lecturerName"],$row["lectureDate"],$row["lectureName"],$row["lectureRating"]]);
                }
            }
        ?>
    </head>
    <body>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Lecturer ratings</h1>
        <h2>Admin: <?php echo ($lecName) ?> </h2>
        <table class="tg" style="margin: 0px auto;">
            <tr>
                <th class="tg-zd1f">Lecturer name</th>
                <th class="tg-zd1f">Lecture date</th>
                <th class="tg-zd1f">Lecture name </th>
                <th class="tg-zd1f">Lecture rating</th>
            </tr>
            <?php
                $old = "";
                for ($i = 0; $i < $numOfLectures; $i++) {
                    echo("<tr>");
                    if ($old != $stack[$i][0]) {
                        echo("<th class='tg-yw4l'>".$stack[$i][0]."</th>");
                    } else {
                        echo("<th class='tg-yw4l'></th>");
                    }
                    $old = $stack[$i][0];
                    for ($j = 1; $j < 4; $j++) {
                        echo("<th class='tg-yw4l'>".$stack[$i][$j]."</th>");
                    }
                    echo("</tr>");
                }
            ?>
        </table>
    </body>
</html>