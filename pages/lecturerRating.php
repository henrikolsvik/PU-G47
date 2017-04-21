<!-- Made by Navjot on 30.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php 
            global $conn;
            $lectureId = $_POST['lectureId'];
            $lectureName = $_POST['lectureName'];
            $lecturerName = $_POST['lectureToFeedback'];

            $sqlRate = "SELECT * FROM Lecture";
            $resultRate = mysqli_query($conn, $sqlRate);

            //variabler for å ha oversikt over verdiene på lecture
            $rateScore = 2;
            $rateCount = 1;
            //sjekker at innholdet er der
            if (!$resultRate) {
                echo(mysqli_error($conn));
            } else {
                if (mysqli_fetch_assoc($resultRate) > 0) {
                    //itererer gjennom Feedback-entiteten etter lecturer med id 2 og samler speed- og difficultyverdier
                    while ($row = mysqli_fetch_assoc($resultRate)) {
                        if ($row["lectureId"] == $lectureId) {
                            if (!($row["lectureRating"] == NULL)) {
                                $rateScore = $rateScore + $row["lectureRating"];
                                $rateCount = $rateCount + 1;
                            }
                        }
                    }
                }
            }
            //regner ut gjennomsnittsscorene
            $rateScore = $rateScore / $rateCount;
        ?>
        <script>
            function endRating() {
                <?php
                    $sql = "UPDATE Lecture
                            SET feedbackActive=0, ratingActive=0
                            WHERE lectureId = $lectureId";
                    if (mysqli_query($conn, $sql)) {
                        echo('alert("Lecture finished");');
                    } else {
                        echo('alert("ERROR");');
                    }
                ?>
            }
        </script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            var rate;

            google.charts.load('current', {'packages':['gauge']});
            google.charts.setOnLoadCallback(drawChart);

            //Function for å oppdatere metere
            function drawChart() {

                //Grafikk og verdi beskrivelser
                var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Rate', 50]
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
                //fart = ( <?php echo( $rateScore ) ?> /4)*100; //regner ut verdien til farten

                chart.draw(data, options);

                //Regelmessig oppdatering av metere
                setInterval(function() {
                    data.setValue(0, 1, rate);
                    chart.draw(data, options);
                }, 1000);
            }

            //Oppdaterer verdiene som meterene settes til
            function updateMeterValues(meterValues) {

                var rateNum = (parseFloat(meterValues[1]) + 2);
                var rateCount = (parseFloat(meterValues[2]) + 1 );
                
                rate = ((rateNum / rateCount)/4)*100; 

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
        </script>
    </head>
    <body>
        <div align="left" id="menuButton">
            <form id="log_out" action="index.php?page=mainPage" method="POST">
                <button class="bButton" type="submit">LOG OUT</button>
            </form>
            <form id="finish" action="index.php?page=lecturerMain" method="POST">
                <button class="bButton" onclick="return endRating()" name="lectureToFeedback" value="<?php echo($lecturerName) ?>" type="submit">FINISH</button>
            </form>
        </div>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <div id="info" align="center">
            <h1>Id: <?php echo ($lectureId) ?> Subject: <?php echo ($lectureName) ?> </h1>
            <h2>Lecturer: <?php echo ($lecturerName) ?> </h2>
        </div>
        <div style="display:flex;justify-content:center;align-items:center;">
                <div id="chart_div" style="width: 400px; height: 120px;"></div>
            </div>
        <form id="toMenu" action="index.php?page=lecturerMain" method="POST">
            <input type=hidden name="lectureToFeedback" value=<?php echo($lecturerName) ?>>
        </form>
    </body>
</html>
