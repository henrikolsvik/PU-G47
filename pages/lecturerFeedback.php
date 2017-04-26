<!-- Made by Helene on 22.02.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="js/feedbackToRatingSwitch.js"></script>
        <?php 
            global $conn;
            //keeping track of lecture and lecturer names and id
            $lectureId = "ERROR";
            $lectureName = "ERROR";
            $lecturerName = "ERROR";

            //Adds a new unfinished lecture to the database
            if ((isset($_POST['lectureName'])) && (isset($_POST['lectureDate']))) {
                $lectureName = $_POST['lectureName'];
                $lecturerId = $_POST['lecturerID'];
                $lectureDate = $_POST['lectureDate'];
                $lecturerName = $_POST['lectureToFeedback'];

                $sql = "INSERT INTO Lecture (lectureName, lecturerId, lectureRating, lectureAvgSpeed, lectureAvgDifficulty, lectureDate, feedbackActive, ratingActive)
                VALUES ('$lectureName', '$lecturerId', 0, 0, 0, '$lectureDate', 1, 0)";

                if (mysqli_query($conn, $sql)) {
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

            $sqlFeed = "SELECT * FROM Feedback";
            $resultFeed = mysqli_query($conn, $sqlFeed);
            $sqlLect = "SELECT * FROM Lecture";
            $resultLect = mysqli_query($conn, $sqlLect);

            while ($rowLect = mysqli_fetch_assoc($resultLect)) {
                if ($rowLect["lectureId"] == $lectureId) {
                    $lectureName = $rowLect["lectureName"];
                }
            }

            //variables for the charts
            $speedScore = 2;
            $speedCount = 1;
            $difficultyScore = 2;
            $difficultyCount = 1;
            $rateScore = 2;
            $rateCount = 1;
            //check if there is any output
            if (!$resultFeed) {
                echo(mysqli_error($conn));
            } else {
                if (mysqli_fetch_assoc($resultFeed) > 0) {
                    //iterating through the Feedback-entity to collect speed and difficulty data for a chosen lecturer
                    while ($row = mysqli_fetch_assoc($resultFeed)) {
                        if ($row["lectureId"] == $lectureId) {
                            if (!($row["speed"] == NULL)) {
                                $speedScore = $speedScore + $row["speed"];
                                $speedCount = $speedCount + 1;
                            }
                            else if (!($row["difficulty"] == NULL)) {
                                $difficultyScore = $difficultyScore + $row["difficulty"];
                                $difficultyCount = $difficultyCount + 1;
                            }
                            else if (!($row["rating"] == NULL)) {
                                $rateScore = $rateScore + $row["rating"];
                                $rateCount = $rateCount + 1;
                            }
                        }
                    }
                }
            }
            
            //calculating the average ratings
            $speedScore = $speedScore / $speedCount;
            $difficultyScore = $difficultyScore / $difficultyCount;
            $rateScore = $rateScore / $rateCount;

            echo("<script>console.log('speed ".$speedScore."');</script>");

            //keeping track of latest comment
            $oldComment = "";
        ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            //these variables are used for the charts
            var fart;
            var vanskelig;
            var rate;
            //keeping track of latest comment
            var oldComment;

            google.charts.load('current', {'packages':['gauge']});
            google.charts.setOnLoadCallback(drawChart);

            //Function to update the meters
            function drawChart() {

                //Description of graphics and values
                var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Speed', 50],
                    ['Difficulty', 50]
                ]);

                var data2 = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Rating', 50]
                ]);

                var options = {
                    width: 600, height: 200,
                    redFrom: 66, redTo: 100,
                    yellowFrom:0, yellowTo: 33,
                    greenFrom:33, greenTo: 66,
                    minorTicks: 2
                };
                
                var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));
                var chart2 = new google.visualization.Gauge(document.getElementById('chart_div2'));

                updatesMeters();

                chart.draw(data, options);
                chart2.draw(data2, options);

                //Updating the values regularly
                setInterval(function() {
                    data.setValue(0, 1, fart);
                    chart.draw(data, options);
                }, 1000);
                setInterval(function() {
                    data.setValue(1, 1, vanskelig);
                    chart.draw(data, options);
                }, 1000);
                setInterval(function() {
                    data2.setValue(0, 1, rate);
                    chart2.draw(data2, options);
                }, 1000);
            }

            //Updating the meter values
            function updateMeterValues(meterValues) {

                var fartNum = (parseFloat(meterValues[1]) + 2);
                var fartCount = (parseFloat(meterValues[2]) + 1 );
                var hardNum = (parseFloat(meterValues[3]) + 2);
                var hardCount = (parseFloat(meterValues[4]) + 1 );
                var rateNum = (parseFloat(meterValues[5]) + 2);
                var rateCount = (parseFloat(meterValues[6]) + 1 );
                
                fart = ((fartNum / fartCount)/4)*100; 
                vanskelig = ((hardNum / hardCount)/4)*100;
                rate = ((rateNum / rateCount)/4)*100;

                console.log((fart/100)*4+1, (vanskelig/100)*4+1, (rate/100)*4+1);

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
                            updateMeterValues(meterValues);
                        }
                    }
                }
                document.getElementById("speed").value = (fart/100)*4+1;
                document.getElementById("difficulty").value = (vanskelig/100)*4+1;
                document.getElementById("rating").value = (rate/100)*4+1;
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
                        }
                    }
                }
            }
            //Updates very fast, it's called LIVE COMMENTING
            window.setInterval(function(){checkComments();}, 500);
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
            <form id="endForm" action="index.php?page=saveFeedback" method="POST" target="target">
                <input id="speed" type=hidden name="avgSpeed" value="">
                <input id="difficulty" type=hidden name="avgDifficulty" value="">
                <button id="end" class="bButton" onclick="return endFeedback()" type="submit" name="lectureId" value="<?php echo($lectureId) ?>">END LECTURE</button>
            </form>
            <form id="finishForm" action="index.php?page=lecturerMain" method="POST">
                <input id="rating" type=hidden name="avgRating" value="">
                <input type=hidden name="lectureToFeedback" value="<?php echo($lecturerName) ?>">
                <button id="finish" class="bButton" name="lectureId" value="<?php echo($lectureId) ?>" type="submit">FINISH</button>
            </form>
            <iframe style="display:none;" name="target"></iframe>
        </div>
        <div id="info" align="center">
            <h1>Id: <?php echo ($lectureId) ?> Subject: <?php echo ($lectureName) ?> </h1>
            <h2>Lecturer: <?php echo ($lecturerName) ?> </h2>
        </div>
        <div id="main">
            <div id="feedback">
                <div id="divQuestion">
                    <div style="display:flex;justify-content:center;align-items:center;">
                        <div id="chart_div1" style="width: 400px; height: 120px;"></div>
                    </div>
                    <div id="chart_div1" style="width: 400px; height: 120px;"></div>
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
            </div>
            <center>
                <div id="divRating" style="display:flex;justify-content:center;align-items:center;">
                    <div id="chart_div2" style="width: 400px; height: 120px;"></div>
                </div>
            </center>
        </div>
    </body>
</html>