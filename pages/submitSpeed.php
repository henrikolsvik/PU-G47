<!-- Made by Henrik on 15.02.17 --> 

<<<<<<< HEAD
<?php
    if (isset($_POST['speedValue'])) {
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        echo("Hi! " . (int)($_POST['speedValue']) . " is the speed you think the lecture is progressing at.");
        $valueToSend = (int)($_POST['speedValue']);
        
        //Getting the table from the DB
        global $conn;
        $sql = "INSERT INTO Feedback (speed, difficulty, time, lectureId)
                VALUES ($valueToSend, NULL,NOW(),1)";
        echo($sql);

        if (mysqli_query($conn, $sql)) {
            echo("<br><br>New record created successfully");
        } else {
            echo("Error: " . $sql . "<br>" . mysqli_error($conn));
        }
    }
=======
Hi <?php echo (int)($_POST['speedValue']);?> is the speed you think the lecture is progressing at. 

<?php
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

    
    
>>>>>>> master
?>