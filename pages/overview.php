<!-- Made by Helene on 14.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body> 
    <style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-zd1f{background-color:#c0c0c0;color:#ffffff;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>  
        <div id="logo">  
            <img src="img/ActiFeedBack.svg"> 
        </div> 

    <?php
    //getting valid lectureIDs from database
    $lecID = 0;
    
    $lecName = $_POST["lecturerToFeedback"]; //Få tilsendt foreleser id fra innloggingssiden;
    global $conn;
    
    $lecID = "SELECT lecturerId FROM lecturer WHERE lecturerName = '$lecName'";
    $resultID = mysqli_query($conn, $lecID);
    while($rowId = mysqli_fetch_assoc($resultID)){
        $lecID = $rowId["lecturerId"];
    }
    

    $sql = "SELECT lectureName, lectureDate, lectureRating, lectureAvgSpeed, lectureAvgDifficulty FROM Lecture WHERE lecturerId = $lecID";
    $result = mysqli_query($conn, $sql);

    //Show error if there are no data in the table
    if (!$result) {
        echo(mysqli_error($conn));
    } else {
        //Print out data using while loop
        if (mysqli_fetch_assoc($result) > 0) {
            $stack = array();
            while($row = mysqli_fetch_assoc($result)) {
                array_push($stack, [$row["lectureDate"],$row["lectureName"],$row["lectureAvgSpeed"],$row["lectureAvgDifficulty"],$row["lectureRating"]]);
            }
        }
    }
?>
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
  <tr>
<?php
  $length = count($stack);
for ($i = 0; $i < $length; $i++) {
    echo("<tr>" );
    for ($j = 0; $i < $length; $i++) {
        echo("<th class='tg-yw4l'>".$stack[$i][$j]."</th>");
    }
    echo("/tr>");
}
?>

</table>

    </body>
</html>

