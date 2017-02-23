
<html>
  	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    <?php 
    global $conn;
    $sql = "SELECT * FROM Feedback";
    $result = mysqli_query($conn, $sql);
    //forteller hvilken lecture det er (er satt til 2 som eksempel)
    $lectureId = 2;
    //variabler for å ha oversikt over verdiene på lecture
    $speedScore = 0;
    $speedCount = 0;
    $difficultyScore = 0;
    $difficultyCount = 0;
    //sjekker at innholdet er der
    if (!$result) {
        echo(mysqli_error($conn));
    } else {
      if (mysqli_fetch_assoc($result) > 0) {
        //itererer gjennom Feedback-entiteten etter lecturer med id 2 og samler speed- og difficultyverdier
        while ($row = mysqli_fetch_assoc($result)) {
          if ($row["lectureId"] == $lectureId) 
            if (!($row["speed"] == NULL)) {
              $speedScore = $speedScore + $row["speed"];
              $speedCount = $speedCount + 1;
            } else if (!($row["difficulty"] == NULL)) {
              $difficultyScore = $difficultyScore + $row["difficulty"];
              $difficultyCount = $difficultyCount + 1;
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
          data.setValue(1, 1, 50);
          chart.draw(data, options);
        }, 100);
      }
    </script>
		<title>Actifeed</title>
	</head>  
    <body>
        <div id="info">
            <h1>fra database: navn på forelesning/fagkode</h1>
            <h2>fra database: dato for forelesning/eventuelt dagen i dag.</h2>
        </div>
        <div id="main">
            
            <div style="display:flex;justify-content:center;align-items:center;">
                    <div id="chart_div" style="width: 400px; height: 120px;"></div>
            </div>
            <div id="chart_div" style="width: 400px; height: 120px;"></div>
            
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    Kommentarer: <br> <br>
            
            <?php 
            global $conn;
            $sql = "SELECT * FROM CommentFB";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
              echo(mysqli_error($conn));
            } else {
              if (mysqli_fetch_assoc($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($row["lectureId"] == 2) {
                    echo ($row["comment"] . "<br>");
                  }
                }
              }
            }
            ?>
          </div>
        </div>
    </body>
</html>
