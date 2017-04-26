<!-- Made by Navjot on 21.04.17 --> 

<?php
    //this submits the rating of the lecture so that the lecturer can get the feedback on their page
    if (isset($_POST['ratingValue'])) {
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        echo("Hi! " . (int)($_POST['ratingValue']) . " is the difficulty you think the lecture has.<br>");  
        $valueToSend = (int)($_POST['ratingValue']);
        $lectureIDToSet = ($_POST['lecID']);
        
        //Getting the table from the DB
        global $conn;
        $sql = "INSERT INTO Feedback (speed, difficulty, rating, time, lectureId)
                VALUES (NULL,NULL,$valueToSend,NOW(),$lectureIDToSet)";
        echo($sql);
        
        if (mysqli_query($conn, $sql)) {
            echo("<br><br>New record created successfully");
        } else {
            echo("Error: " . $sql . "<br>" . mysqli_error($conn));
        }
    }
?>