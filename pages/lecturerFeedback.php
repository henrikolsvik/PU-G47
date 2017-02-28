<!-- Made by Helene on 22.02.17 --> 

<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <?php 
        global $conn;
        $lectureId = $_POST['lectureToFeedback'];
        $sqlFeed = "SELECT * FROM Feedback";
        $resultFeed = mysqli_query($conn, $sqlFeed);
        $sqlLect = "SELECT * FROM Lecture";
        $resultLect = mysqli_query($conn, $sqlLect);
        $sqlForeleser = "SELECT lecturerName, lecture.lecturerId, lecture.lectureId FROM lecture JOIN lecturer ON lecture.lecturerId = lecturer.lecturerId WHERE lectureId = '$lectureId'";
        //$sqlForeleser = "SELECT lecturerName FROM Lecture JOIN Lecturer ON Lecture.lecturerId = Lecturer.lecturerId WHERE lectureId = echo$lectureId'";
        $resultForeleser = mysqli_query($conn, $sqlForeleser);

        while($rowForeleser = mysqli_fetch_assoc($resultForeleser)){
            $foreleser = $rowForeleser["lecturerName"];
        }

        while ($rowLect = mysqli_fetch_assoc($resultLect)) {
            if ($rowLect["lectureId"] == $lectureId) {
                $lectureName = $rowLect["lectureName"];
            }
        }

        //variabler for å ha oversikt over verdiene på lecture
        $speedScore = 2;
        $speedCount = 1;
        $difficultyScore = 2;
        $difficultyCount = 1;
        //sjekker at innholdet er der
        if (!$resultFeed) {
            echo(mysqli_error($conn));
        } else {
            if (mysqli_fetch_assoc($resultFeed) > 0) {
                //itererer gjennom Feedback-entiteten etter lecturer med id 2 og samler speed- og difficultyverdier
                while ($row = mysqli_fetch_assoc($resultFeed)) {
                if ($row["lectureId"] == $lectureId) {
                        if (!($row["speed"] == NULL)) {
                            $speedScore = $speedScore + $row["speed"];
                            $speedCount = $speedCount + 1;
                        }
                    }
                }
            }
        }
        $resultFeed = mysqli_query($conn, $sqlFeed);
        if (!$resultFeed) {
            echo(mysqli_error($conn));
        } else {
            if (mysqli_fetch_assoc($resultFeed) > 0) {
                while ($row = mysqli_fetch_assoc($resultFeed)) {
                    if ($row["lectureId"] == $lectureId) {
                        if (!($row["difficulty"] == NULL)) {
                            $difficultyScore = $difficultyScore + $row["difficulty"];
                            $difficultyCount = $difficultyCount + 1;
                        }
                    }
                }
            }
            //regner ut gjennomsnittsscorene
            $speedScore = $speedScore / $speedCount;
            $difficultyScore = $difficultyScore / $difficultyCount;
        }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Fart', 10],
                ['Vanskelighetsgrad', 10]
            ]);

            var options = {
                width: 600, height: 200,
                redFrom: 66, redTo: 100,
                yellowFrom:0, yellowTo: 33,
                greenFrom:33, greenTo: 66,
                minorTicks: 2
            };

            var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

            var fart = ( <?php echo( $speedScore ) ?> /4)*100; //regner ut verdien til farten
            var vanskelig = (<?php echo( $difficultyScore ) ?> /4)*100; //regner ut verdien til vanskelighetsgraden

            chart.draw(data, options);

            setInterval(function() {
                data.setValue(0, 1, fart);
                chart.draw(data, options);
            }, 100);
            setInterval(function() {
                data.setValue(1, 1, vanskelig);
                chart.draw(data, options);
            }, 100);
        }
    </script>
    <title>Actifeed</title>
    </head>  
    <body>
        <div id="info">
            <h1>Emne: <?php echo ($lectureName) ?> </h1>
            <h2>Foreleser: <?php echo ($foreleser) ?> </h2>
        </div>
        <div id="main">

            <div style="display:flex;justify-content:center;align-items:center;">
                <div id="chart_div" style="width: 400px; height: 120px;"></div>
            </div>
            <div id="chart_div" style="width: 400px; height: 120px;"></div>

            Kommentarer: <br> <br>
            <?php 
                global $conn;
                $sqlComm = "SELECT * FROM CommentFB";
                $resultComm = mysqli_query($conn, $sqlComm);
                if (!$resultComm) {
                    echo(mysqli_error($conn));
                } else {
                    if (mysqli_fetch_assoc($resultComm) > 0) {
                        while ($row = mysqli_fetch_assoc($resultComm)) {
                            if ($row["lectureId"] == $lectureId) {
                                $onclick = "this.parentElement.style.display='none';";
                                echo ("<div class='alert'>
                                    <span class='closebtn' onclick=" . $onclick . ">&times;</span> " .
                                    $row["comment"] . "<br>"
                                    . "</div>"
                                );
                            }
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>