<!-- Made by Henrik on 22.02.17 --> 
<!-- <input type="submit" name="update" value=" Apply " style="position: absolute; height: 0px; width: 0px; border: none; padding: 0px;" hidefocus="true" tabindex="-1"/> -->

<?php

//getting valid lectureIDs from database
global $conn;
    $sql = "SELECT lectureId FROM lecture";
    $result = mysqli_query($conn, $sql);

    //Show error if there are no data in the table
    if (!$result) {
        echo(mysqli_error($conn));
    } else {
        //Print out data using while loop
        if (mysqli_fetch_assoc($result) > 0) {
            $stack = array();
            while($row = mysqli_fetch_assoc($result)) {
                array_push($stack, $row["lectureId"]);
            }
        }
    }

?>

<script>

//php array to javascript array
<?php
$js_array = json_encode($stack);
echo "var idArray = ". $js_array . ";\n";
?>

//Checking valid id for lecture for now this means not null
function checkNull(){
    if(document.getElementById("selectLectureID").value == ""){
        alert("you need to enter an id, my dude!");
        return false;
    }
    if((idArray.indexOf(document.getElementById("selectLectureID").value)) == -1){
        alert("There is no lecture by this id");
        return false;
    }
    return true;
}


//Setting action atrib to refer user to studentfeedback
function setGotoStudent(){
    document.getElementById("formToValid").action = "index.php?page=studentfeedback";
    return true;
}

//Setting action atrib to refer user to lecturerfeedback
function setGotoLecturer(){
    document.getElementById("formToValid").action = "index.php?page=feedback";
    return true;
}


</script>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <center>
            <form id="formToValid" action="" onsubmit="return checkNull()" method="POST">
                <input id="selectLectureID" type="number" name="lectureToFeedback" value="" style="width: 5em; max=5; height:1em; font-size:128px; margin-top:calc(17%);">
                </br>
                </br>
                <input id="studentButton" type="submit" onclick="return setGotoStudent(this)" name="studentIS" value="student">
                <input id="lecturerButton" type="submit" onclick="return setGotoLecturer(this)" name="lecturerIS" value="lecturer">
            </form>
        </center>
    </body>
</html>
