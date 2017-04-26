<!-- Made by Navjot on 25.04.17 --> 

<?php
    if (isset($_POST['avgSpeed']) && isset($_POST['avgDifficulty'])) {
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $avgSpeed = (int)($_POST['avgSpeed']);
        $avgDifficulty = (int)($_POST['avgDifficulty']);
        $lectureIDToSet = ($_POST['lectureId']);
        
        //Getting the table from the DB
        global $conn;
        $sql = "UPDATE Lecture
                SET lectureAvgSpeed=$avgSpeed, lectureAvgDifficulty=$avgDifficulty, feedbackActive=0, ratingActive=1
                WHERE lectureId=$lectureIDToSet";
        
        if (mysqli_query($conn, $sql)) {
            echo("<br><br>New record created successfully");
        } else {
            echo("Error: " . $sql . "<br>" . mysqli_error($conn));
        }
    }
?>