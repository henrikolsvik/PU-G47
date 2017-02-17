<!-- Made by Henrik on 16.02.17 --> 

Hi <?php echo (int)($_POST['textFeedback']);?> is the speed you think the lecture is progressing at. 

<?php
    $valueToSend = htmlspecialchars($_POST['textFeedback']);
    echo($valueToSend);
    //Getting the table from the DB
    global $conn;
    $sql = "INSERT INTO Comment (comment, feedbackId)
    VALUES ('$valueToSend' , 2)";
    
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