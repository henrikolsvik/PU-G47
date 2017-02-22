<!-- Made by Henrik on 16.02.17 --> 

<?php
    if (isset($_POST['difficultyValue'])) {
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        echo("Hi! ". (int)($_POST['difficultyValue']) . " is the difficulty you think the lecture has.<br>");  
        $valueToSend = (int)($_POST['difficultyValue']);
        
        //Getting the table from the DB
        global $conn;
        $sql = "INSERT INTO Feedback (speed, difficulty, time, lectureId)
                VALUES (NULL, $valueToSend,NOW(),2)";
        echo($sql);
        
        if (mysqli_query($conn, $sql)) {
            echo("<br><br>New record created successfully");
        } else {
            echo("Error: " . $sql . "<br>" . mysqli_error($conn));
        }
    }
?>