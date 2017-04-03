<?php
    //getting valid lectureIDs from database
    global $conn;
    $sqlLID = "SELECT lectureId FROM lecture";
    $resultLID = mysqli_query($conn, $sqlLID);

    //Show error if there are no data in the table
    if (!$resultLID) {
        echo(mysqli_error($conn));
    } else {
        //Print out data using while loop
        $stackLID = array();
        while($row = mysqli_fetch_assoc($resultLID)) {
            array_push($stackLID, $row["lectureId"]);
        }
    }

    //getting valid lecturer names from database
    $sqlLName = "SELECT lecturerName FROM lecturer";
    $resultLName = mysqli_query($conn, $sqlLName);

    //Show error if there are no data in the table
    if (!$resultLName) {
        echo(mysqli_error($conn));
    } else {
        //Print out data using while loop
        $stackLName = array();
        while($row = mysqli_fetch_assoc($resultLName)) {
            array_push($stackLName, $row["lecturerName"]);
        }
    }

    $sqlAName = "SELECT lecturerName FROM lecturer";
    $resultAName = mysqli_query($conn, $sqlAName);

    //Show error if there are no data in the table
    if (!$resultAName) {
        echo(mysqli_error($conn));
    } else {
        //Print out data using while loop
        $stackAName = array();
        while($row = mysqli_fetch_assoc($resultAName)) {
            array_push($stackAName, $row["lecturerName"]);
        }
    }
?>
<script>
    <?php
        //php array to javascript array
        $js_arrayLID = json_encode($stackLID);
        echo("var idArray = ". $js_arrayLID . ";\n");

        $js_arrayAName = json_encode($stackAName);
        echo("var adminArray = ". $js_arrayAName . ";\n");

        $js_arrayLName = json_encode($stackLName);
        echo("var nameArray = ". $js_arrayLName . ";\n");
    ?>
</script>