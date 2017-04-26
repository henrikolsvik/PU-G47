<!-- Made by Navjot on 23.03.2017 -->

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <?php
            global $conn;
            //getting currently logged in lecturerID
            $lecID = null;
            $lecName = $_POST["lectureToFeedback"];
            $sqlID = "SELECT lecturerId FROM lecturer WHERE lecturerName='$lecName'";
            $resultID = mysqli_query($conn, $sqlID);
            while($rowID = mysqli_fetch_assoc($resultID)){
                $lecID = $rowID["lecturerId"];
            }
            
            $sql = "SELECT lecturerName, AVG(lectureRating) FROM Lecturer JOIN Lecture ON Lecturer.lecturerId = Lecture.lecturerId GROUP BY lecturerName";
            $result = mysqli_query($conn, $sql);
            $numOfLecturers = 0;

            //Show error if there are no data in the table
            if (!$result) {
                echo(mysqli_error($conn));
            } else {
                //Print out data using while loop
                $stack = array();
                while($row = mysqli_fetch_assoc($result)) {
                    $numOfLecturers++;
                    array_push($stack, [$row["lecturerName"],substr($row["AVG(lectureRating)"], 0, 3)]);
                }
            }
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
        <h1>Lecturer ratings</h1>
        <h2>Admin: <?php echo ($lecName) ?> </h2>
        <table class="tg" style="margin: 0px auto;">
            <tr>
                <th class="tg-zd1f">Lecturer name</th>
                <th class="tg-zd1f">Lecturer rating</th>
                <th class="tg-zd1f">Lectures</th>
            </tr>
            <?php
                for ($i = 0; $i < $numOfLecturers; $i++) {
                    echo("<tr>");
                    for ($j = 0; $j < 2; $j++) {
                        echo("<th class='tg-yw4l'>".$stack[$i][$j]."</th>");
                    }
                    echo('<th class="tg-yw41">');
                    echo('<div id="enter"><form id="showLectures" action="index.php?page=adminOverviewLectures" method="POST">');
                    echo('<input type="hidden" name="lecturerId" value="'.$stack[$i][0].'"/>');
                    echo('<button class="lectureButton" name="lectureToFeedback" value="'.$lecName.'" type="submit">MORE</button>');
                    echo("</form></div></th></tr>");
                }
            ?>
        </table>
    </body>
</html>