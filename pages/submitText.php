<!-- Made by Henrik on 16.02.17 --> 

<?php 
    if (isset($_POST['textFeedback'])) {
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        echo("Hi! ". $_POST['textFeedback'] . " is the text.<br>");  
        $valueToSend = htmlspecialchars($_POST['textFeedback']);

        //Getting the table from the DB
        global $conn;
        $sql = "INSERT INTO CommentFB (comment, lectureId)
                VALUES ('$valueToSend' , 3)";
        echo($sql);

        if (mysqli_query($conn, $sql)) {
            echo("<br><br>New record created successfully");
        } else {
            echo("Error: " . $sql . "<br>" . mysqli_error($conn));
        }
    }
?>