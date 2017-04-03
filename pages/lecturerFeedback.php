<!-- Made by Helene on 22.02.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php 
            global $conn;
            $lectureId = "ERROR";
            $lectureName = "ERROR";
            $lecturerName = "ERROR";

            if ((isset($_POST['lectureName'])) && (isset($_POST['lectureDate']))) {
                $lectureName = $_POST['lectureName'];
                $lecturerId = $_POST['lecturerID'];
                $lectureDate = $_POST['lectureDate'];
                $lecturerName = $_POST['lectureToFeedback'];

                $sql = "INSERT INTO Lecture (lectureName, lecturerId, lectureRating, lectureAvgSpeed, lectureAvgDifficulty, lectureDate, active)
                VALUES ('$lectureName', '$lecturerId', 0, 0, 0, '$lectureDate', 1)";

                if (mysqli_query($conn, $sql)) {
                    echo('<script type="text/javascript">alert("Success");</script>');
                    $sqlSelectLectureId = "SELECT lectureId FROM lecture WHERE lectureName='$lectureName'";
                    $resultSelectLectureId = mysqli_query($conn, $sqlSelectLectureId);
                    while ($rowSelectLectureId = mysqli_fetch_assoc($resultSelectLectureId)) {
                        $lectureId = $rowSelectLectureId["lectureId"];
                    }
                } else {
                    echo('<script type="text/javascript">alert("Failed");</script>');
                }
            }

            if ((isset($_POST['lectureToFeedback'])) && (isset($_POST['lectureId']))) {
                $lecturerName = $_POST['lectureToFeedback'];
                $lectureId = $_POST['lectureId'];
            }

            $foreleser = $lecturerName;
            $sqlFeed = "SELECT * FROM Feedback";
            $resultFeed = mysqli_query($conn, $sqlFeed);
            $sqlLect = "SELECT * FROM Lecture";
            $resultLect = mysqli_query($conn, $sqlLect);

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

            //keep track of latest comment
            $oldComment = "";
        ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            var fart;
            var vanskelig;
            //keep track of latest comment
            var oldComment;

            google.charts.load('current', {'packages':['gauge']});
            google.charts.setOnLoadCallback(drawChart);

            //Function for å oppdatere metere
            function drawChart() {

                //Grafikk og verdi beskrivelser
                var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Fart', 50],
                    ['Vanskelighetsgrad', 50]
                ]);

                var options = {
                    width: 600, height: 200,
                    redFrom: 66, redTo: 100,
                    yellowFrom:0, yellowTo: 33,
                    greenFrom:33, greenTo: 66,
                    minorTicks: 2
                };
                
                var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

                updatesMeters();

                //Oppsett av verdier
                //fart = ( <?php echo( $speedScore ) ?> /4)*100; //regner ut verdien til farten
                //vanskelig = (<?php echo( $difficultyScore ) ?> /4)*100; //regner ut verdien til vanskelighetsgraden

                chart.draw(data, options);

                //Regelmessig oppdatering av metere
                setInterval(function() {
                    data.setValue(0, 1, fart);
                    chart.draw(data, options);
                }, 1000);
                setInterval(function() {
                    data.setValue(1, 1, vanskelig);
                    chart.draw(data, options);
                }, 1000);
            }

            //Oppdaterer verdiene som meterene settes til
            function updateMeterValues(meterValues) {

                var fartNum = (parseFloat(meterValues[1]) + 2);
                var hardNum = (parseFloat(meterValues[3]) + 2);
                var fartCount = (parseFloat(meterValues[2]) + 1 );
                var hardCount = (parseFloat(meterValues[4]) + 1 );
                
                fart = ((fartNum / fartCount)/4)*100; 
                vanskelig = ((hardNum / hardCount)/4)*100;

            }

            //Function to update the difficulty and speed meters
            function updatesMeters() {
                //Obtaining Lecture ID to pass on
                var lectureID = "<?php echo $lectureId ?>";
                //Ajax magic (set connection to script and run)
                var xhttp;
                xhttp = new XMLHttpRequest();
                var data = "lectureID=" + lectureID;
                xhttp.open("POST", "index.php?page=updateLecturerRatings", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.send(data);
                xhttp.onreadystatechange = function(){
                    if (xhttp.readyState == 4) {  
                        if (xhttp.status == 200) { 
                            //String pharsing using € as divider to exclude unneeded headers
                            var meterValues = xhttp.responseText.split("€");
                            //alert(xhttp.responseText);
                            updateMeterValues(meterValues);
                        } else {
                            //alert('There was a problem with the request.');  
                        }  
                    }
                }
            }
            window.setInterval(function(){updatesMeters();}, 5000);

            //Function to add the latest comment in commentField if it does not exist
            function updateCommentfield(comment) {
                var comments = comment[1];
                //Choosing the right div
                var div = document.getElementById('commentField');
                //Check if comment already exist. This will not allow you to spam the same comment over and over again, itzz a verry naice ;)
                var subString = comments.substring(comments.lastIndexOf("</span>")+8,comments.lastIndexOf("<br>"));
                if (subString != oldComment) {
                    div.innerHTML = div.innerHTML + comments;
                    oldComment = subString;
                }
            }

            //Function to update the comments
            function checkComments() {
                //Obtaining Lecture ID to pass on
                var lectureID = "<?php echo $lectureId ?>";
                var xhttp;
                xhttp = new XMLHttpRequest();
                var data = "lectureID=" + lectureID;
                xhttp.open("POST", "index.php?page=updateLecturerComments", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.send(data);
                xhttp.onreadystatechange = function(){
                    if (xhttp.readyState == 4) {  
                        if (xhttp.status == 200) { 
                            //String pharsing using € as divider to exclude unneeded headers
                            var comments = xhttp.responseText.split("€");
                            //Updating comment field
                            updateCommentfield(comments);
                        } else {  
                            //Commented this away. This will show up everytime because of the comment refresh speed  
                            //alert('There was a problem with the request.');  
                        }  
                    }
                }
            }
            //Updates very fast, it's called LIVE COMMENTING
            window.setInterval(function(){checkComments();}, 100);
        
        </script>
    </head>  
    <body>
        <div align="left" id="menuButton">
            <form id="log_out" action="index.php?page=mainPage" method="POST">
                <button class="bButton" type="submit">LOG OUT</button>
            </form>
            <form id="menu" action="index.php?page=lecturerMain" method="POST">
                <button class="bButton" name="lectureToFeedback" value="<?php echo($lecturerName) ?>" type="submit">MENU</button>
            </form>
            <form id="endLecture" action="index.php?page=lecturerRating" method="POST">
                <input type=hidden name="lectureId" value="<?php echo($lectureId) ?>">
                <input type=hidden name="lectureName" value="<?php echo($lectureName) ?>">
                <button class="bButton" name="lectureToFeedback" value="<?php echo($lecturerName) ?>" type="submit">END LECTURE</button>
            </form>
        </div>
        <div id="info" align="center">
            <h1>Id: <?php echo ($lectureId) ?> Subject: <?php echo ($lectureName) ?> </h1>
            <h2>Lecturer: <?php echo ($foreleser) ?> </h2>
        </div>
        
        <div id="main">
            <div style="display:flex;justify-content:center;align-items:center;">
                <div id="chart_div" style="width: 400px; height: 120px;"></div>
            </div>
            <div id="chart_div" style="width: 400px; height: 120px;"></div>
            <center>
                <h2>Kommentarer:</h2>
                <div id="commentField">
                    <?php 
                        //Connecting to the database and getting the comments
                        global $conn;
                        $sqlComm = "SELECT * FROM CommentFB";
                        $resultComm = mysqli_query($conn, $sqlComm);
                        if (!$resultComm) {
                            echo(mysqli_error($conn));
                        } else {
                            if (mysqli_fetch_assoc($resultComm) > 0) {
                                while ($row = mysqli_fetch_assoc($resultComm)) {
                                    if ($row["lectureId"] == $lectureId) {
                                        //Printing out the comments in separate alert divs
                                        $onclick = "this.parentElement.style.display='none';";
                                        echo ("<div class='alert'>
                                            <span class='closebtn' onclick=" . $onclick . ">&times;</span> " .
                                            $row["comment"] . "<br>"
                                            . "</div>"
                                        );
                                        //Saving latest comment
                                        $oldComment = $row["comment"];
                                    }
                                }
                            }
                        }
                    ?>
                    <!-- Transfers the latest comment from PHP to JavaScript -->
                    <script> oldComment = "<?php echo($oldComment) ?>" </script>
                </div>
            </center>
        </div>
    </body>
</html>