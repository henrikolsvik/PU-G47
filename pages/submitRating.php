<!-- Made by Navjot on 21.04.17 --> 

<?php
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
        $sql = "INSERT INTO Lecture (lectureRating, lectureId)
                VALUES ($valueToSend,$lectureIDToSet)";
        echo($sql);
        
        if (mysqli_query($conn, $sql)) {
            echo("<br><br>New record created successfully");
        } else {
            echo("Error: " . $sql . "<br>" . mysqli_error($conn));
        }
    }
?>