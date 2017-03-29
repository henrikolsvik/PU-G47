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

//Regner antrall dager mellom dagen i dag og dato lagret i database
        $chartData = array();
        for ($i = 0; $i < $numOfLectures; $i++) {
            date_default_timezone_set('Europe/Warsaw');
            $from = strtotime($stack[$i][1]); //TODO: Bytt ut med variabel for dato fra databsen
            $today = time();
            $difference = ($today - $from)/86400; // (60 * 60 * 24)
            array_push($chartData, [$difference,$stack[$i][5]]);
        }
        ?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

  google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBasic);

var limit= 50; //Hvor mange dager burker har valgt å se statistikk fra

function drawBasic() {

    var jArray= <?php echo json_encode($chartData ); ?>;
    console.log(jArray);

    var sub_array = [];

    for(var i=0;i<jArray.length;i++){
        if (jArray[i][0] < limit){ //TODO: skrive index etter jArray[i][0], vet ikke hvorfor det ikke funker
                sub_array.push(jArray[i]);
        }
    }
    console.log(sub_array);

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'Rating');

      data.addRows(sub_array);

      var options = {
        hAxis: {
          title: 'Days from today'
        },
        vAxis: {
          title: 'Rating'
        },
        
        backgroundColor: '#ace2dd',
        colors: ['#009444']
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);

    }
function dispOptionValue() {
 var select = document.getElementById("numberOfDays").value;
 //alert(select.options.value);
 limit = select;
}
  </script>

    </head>
    <body> 
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Feedback from previous lectures</h1>
        <h2>Lecturer: <?php echo ($lecName) ?> </h2>

        <div id="chart_div"></div>
        <br>
        <select id="numberOfDays" onchange="dispOptionValue()">
            <option value="7">7 days</option>
            <option value="14">14 days</option>
            <option value="30">1 month</option>
            <option value="360">1 year</option>
        </select>
        <table class="tg" style="margin: 0px auto;">
            <tr>
                <th class="tg-zd1f">Id</th>
                <th class="tg-zd1f">Date</th>
                <th class="tg-zd1f">Course name</th>
                <th class="tg-zd1f">Average speed<br>(slow 0-5 fast)</th>
                <th class="tg-zd1f">Average difficulty<br>(easy 0-5 hard)</th>
                <th class="tg-zd1f">Total rating<br>(bad 0-5 good)</th>
            </tr>
            <?php
                for ($i = 0; $i < $numOfLectures; $i++) {
                    echo("<tr>" );
                    for ($j = 0; $j < 6; $j++) {
                        echo("<th class='tg-yw4l'>".$stack[$i][$j]."</th>");
                    }
                    echo("</tr>");
                }
            ?>
        </table>
    </body>
</html>

