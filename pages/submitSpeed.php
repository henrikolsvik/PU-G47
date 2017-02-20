<!-- Made by Henrik on 15.02.17 --> 

<?php
    isset($_POST['speedValue']);
    echo("Hi" . (int)($_POST['speedValue']) . "is the speed you think the lecture is progressing at.");
    $valueToSend = (int)($_POST['speedValue']);
     
    //Getting the table from the DB
    global $conn;
    $sql = "INSERT INTO Feedback (speed, difficulty, time, lectureId)
    VALUES ($valueToSend, 2,2017-03-11,2)";
    
    echo($sql);

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "mydb";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

?>