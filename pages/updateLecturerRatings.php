<?php

    //Made by Henrik on 01.03.17

    include('../includes/config.php');
    global $conn;
    $lectureId = $_POST['lectureID'];
    
    $sqlFeed = "SELECT * FROM Feedback";
    $resultFeed = mysqli_query($conn, $sqlFeed);
    
    
    //Getting results from individual row, ignoring empty ones and adding together valid ones
    if (!$resultFeed) {
        echo(mysqli_error($conn));
    } else {
        if (mysqli_fetch_assoc($resultFeed) > 0) {
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
    
    //Reset resultFeed (is emptied during mysqli_fetch_assoc)
    $sqlFeed = "SELECT * FROM Feedback";
    $resultFeed = mysqli_query($conn, $sqlFeed);

    //Getting results from individual row, ignoring empty ones and adding together valid ones
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
    }

    //Sending relevant variables through ajax.
    echo "€".$speedScore;
    echo "€".$speedCount;
    echo "€".$difficultyScore;
    echo "€".$difficultyCount;
?>