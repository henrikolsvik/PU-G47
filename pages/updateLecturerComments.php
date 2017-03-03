<?php
    //Made by Navjot on 02.03.17

    include('../includes/config.php');
    global $conn;
    $lectureId = $_POST['lectureID'];
    $sqlFeed = "SELECT * FROM CommentFB";
    $resultFeed = mysqli_query($conn, $sqlFeed);

    //Getting results from individual row, ignoring empty ones and adding together valid ones
    if (!$resultFeed) {
        echo(mysqli_error($conn));
    } else {
        if (mysqli_fetch_assoc($resultFeed) > 0) {
            while ($row = mysqli_fetch_assoc($resultFeed)) {
                if ($row["lectureId"] == $lectureId) {
                    //Printing out the comments in separate alert divs
                    $onclick = "this.parentElement.style.display='none';";
                    $comment =
                        "<div class='alert'>
                        <span class='closebtn' onclick=" . $onclick . ">&times;</span> " .
                        $row["comment"] . "<br>"
                        . "</div>";
                }
            }
        }
    }

    //Sending relevant variables through ajax.
    echo "€".$comment;
?>