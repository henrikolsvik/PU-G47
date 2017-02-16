<?php
    //Getting the table from the DB
    global $conn;
    $sql = "SELECT * FROM Lecturer";
    $result = mysqli_query($conn, $sql);

    //Printing out the values
    echo("The main page works! :D<br><br>");
    //Show error if there are no data in the table
    if (!$result) {
        echo(mysqli_error($conn));
    } else {
        //Print out data using while loop
        if (mysqli_fetch_assoc($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo("Id: " . $row["lecturerId"] .
                "<br> Name: " . $row["lecturerName"] .
                "<br> Rating: " . $row["lecturerRating"] .
                "<br><br>");
            }
        }
    }
?>