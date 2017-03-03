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
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        var fart;
        var vanskelig;

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
        function updateMeterValues(meterValues){

            var fartNum = (parseFloat(meterValues[1]) + 2);
            var hardNum = (parseFloat(meterValues[3]) + 2);
            var fartCount = (parseFloat(meterValues[2]) + 1 );
            var hardCount = (parseFloat(meterValues[4]) + 1 );
            
            fart = ((fartNum / fartCount)/4)*100; 
            vanskelig = ((hardNum / hardCount)/4)*100;

        }

        //Function to update the difficulty and speed meters
        function updatesMeters(){
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
                    alert('There was a problem with the request.');  
                    }  
                }
            }
        }

        window.setInterval(function(){updatesMeters();}, 5000);
    
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
                            }
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>