<?php

    //Made by Henrik on 01.03.17

    include('../includes/config.php');
    global $conn;
    $lectureId = $_POST['lectureID'];
    
    $sqlFeed = "SELECT * FROM Feedback";
    $resultFeed = mysqli_query($conn, $sqlFeed);

    //Valid Time Period
    $minutesToInclude = 10;

    //Time stamps for comparison
    $timeToCheck = date("U") + 60*60;
    $timeToCheck = $timeToCheck - 60*$minutesToInclude;
    $currentTime = date("U") + 60*60;
    

    //Variable declaration speed and difficulty
    $speedScore = 0;
    $speedCount = 0;
    $difficultyScore = 0;
    $difficultyCount = 0;

    //Getting results from individual row, ignoring empty ones and adding together valid ones
    if (!$resultFeed) {
        echo(mysqli_error($conn));
    } else {
        if (mysqli_fetch_assoc($resultFeed) > 0) {
            while ($row = mysqli_fetch_assoc($resultFeed)) {
                if ($row["lectureId"] == $lectureId) {
                    //Fetches values and treats them
                    if (!($row["speed"] == NULL)) {
                        $thisTime = strtotime($row["time"]);
                        if($thisTime > $timeToCheck){
                            //Gives percentage weighting based on timeperiod
                            $weight = ((60*$minutesToInclude - ($currentTime - $thisTime))/(60*$minutesToInclude));
                            $speedScore = $speedScore + ($row["speed"]*$weight);
                            $speedCount = $speedCount + 1*$weight;
                            }
                        }
                     else if (!($row["difficulty"] == NULL)) {
                        $thisTime = strtotime($row["time"]);
                        if($thisTime > $timeToCheck){
                            //Gives percentage weighting based on timeperiod
                            $weight = ((60*$minutesToInclude - ($currentTime - $thisTime))/(60*$minutesToInclude));
                            $difficultyScore = $difficultyScore + ($row["difficulty"]*$weight);
                            $difficultyCount = $difficultyCount + (1*$weight);
                        } 
                    }
                }
            }
        }
    }
    
    //Sending relevant variables through ajax.
    echo "€".$speedScore;
    echo "€".$speedCount;
    echo "€".$difficultyScore;
    echo "€".$difficultyCount;
?>