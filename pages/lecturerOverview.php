<!-- Made by Helene on 14.03.17 --> 

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
            
            $sql = "SELECT lectureName, lectureDate, lectureRating, lectureAvgSpeed, lectureAvgDifficulty FROM Lecture WHERE lecturerId='$lecID'";
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
                    array_push($stack, [$row["lectureDate"],$row["lectureName"],$row["lectureAvgSpeed"],$row["lectureAvgDifficulty"],$row["lectureRating"]]);
                }
            }
        ?>
    </head>
    <body> 
        <style type="text/css">
            .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td {font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
            .tg th {font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
            .tg .tg-baqh {text-align:center;vertical-align:top}
            .tg .tg-zd1f {background-color:#c0c0c0;color:#ffffff;vertical-align:top}
            .tg .tg-yw4l {vertical-align:top}
        </style>  
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Feedback from previous lectures</h1>
        <h2>Navn: <?php echo ($lecName) ?> </h2>
        <table class="tg" style="margin: 0px auto;">
            <tr>
                <th class="tg-zd1f">Date</th>
                <th class="tg-zd1f">Course name</th>
                <th class="tg-zd1f">Average speed </th>
                <th class="tg-zd1f">Average difficulty</th>
                <th class="tg-zd1f">Total rating</th>
            </tr>
            <?php
                for ($i = 0; $i < $numOfLectures; $i++) {
                    echo("<tr>" );
                    //change to 5 to 6 and add a button that directs to feedback site for the given lecture
                    for ($j = 0; $j < 5; $j++) {
                        echo("<th class='tg-yw4l'>".$stack[$i][$j]."</th>");
                    }
                    echo("</tr>");
                }
            ?>
        </table>
    </body>
</html>

