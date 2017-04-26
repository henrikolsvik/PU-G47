<?php
    //Made by Navjot on 02.03.17

    include('includes/config.php');
    global $conn;
    $lectureId = $_POST['lectureID'];
    $sql = "SELECT lectureId, feedbackActive, ratingActive FROM Lecture WHERE lectureId=$lectureId";
    $result = mysqli_query($conn, $sql);

    //Getting information about if the lecture is in feedback-mode or rating-mode
    //or if the lecture has ended
    if (!$result) {
        echo(mysqli_error($conn));
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $feedbackActive = $row["feedbackActive"];
            $ratingActive = $row["ratingActive"];
        }
    }

    //Sending relevant variables through ajax.
    echo "€".$feedbackActive;
    echo "€".$ratingActive;
?>