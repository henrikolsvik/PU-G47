<!-- Made by Henrik on 22.02.17 --> 

<?php
    //getting valid lectureIDs from database
    global $conn;
    $sqlLID = "SELECT lectureId FROM lecture WHERE feedbackActive=1 OR ratingActive=1";
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
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <script type="text/javascript" src="js/tabController.js"></script>
        <script type="text/javascript" src="js/validationMainPage.js"></script>
    </head>
    <body>
        <div class="logo">
            <img src="img/ActiFeedback.svg">
        </div>
        <div class="main">
            <center>
            <div class="tab">
                <button class="tablinks" title="Student" onclick="openTab(event, 'Student')" id="defaultOpen"><img src="img/student_icon.png" height="60px" width="50px"/></button>
                <button class="tablinks" title="Lecturer" onclick="openTab(event, 'Lecturer')"><img src="img/lecturer_icon.png" height="60px" width="60px"/></button>
                <button class="tablinks" title="Admin" onclick="openTab(event, 'Faculty admin')"><img src="img/admin_icon.png" height="60px" width="50px"/></button>
            </div>
            </center>
            <center>
                <div id="Student" class="tabcontent">
                    <form id="formToValidS" action="" onsubmit="return checkNullStudent()" method="POST">
                        <div id="formStudent"> 
                            <input class="textInput" id="selectLectureID" type="number" name="lectureToFeedback" value="" placeholder="Lecture ID"/> 
                            </br> 
                            <input class="aButton" type="submit" onclick="return setGotoStudent(this)" name="studentIS" value="ENTER"/> 
                        </div> 
                    </form>
                </div>
                <div id="Lecturer" class="tabcontent">
                    <form id="formToValidL" action="" onsubmit="return checkNullLecturer()" method="POST">
                        <div id="formLecturer"> 
                            <input class="textInput" id="usernameL" type="text" name="lectureToFeedback" value="" placeholder="Username"/>
                            </br>
                            <input class="textInput" id="passwordL" type="password" name="passwordL" value="" placeholder="Password"/>
                            </br>
                            <input class="aButton" id="lecturerButton" type="submit" name="lecturerIS" value="LOG IN"/>  
                        </div>
                    </form>
                </div>
                <div id="Faculty admin" class="tabcontent">
                    <form id="formToValidA" action="" onsubmit="return checkNullAdmin()" method="POST">
                        <div id="formAdmin"> 
                            <input class="textInput" id="usernameA" type="text" name="lectureToFeedback" value="" placeholder="Username"/> 
                            </br>
                            <input class="textInput" id="passwordA" type="password" name="passwordA" value="" placeholder="Password"/> 
                            </br>
                            <input class="aButton" id="adminButton" type="submit" name="adminIS" value="LOG IN"/>  
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </body>
</html>

<!-- Open student tab as default -->
<script> document.getElementById("defaultOpen").click(); </script>

<?php
    if ((isset($_POST['lectureToFeedback']) != "") && (isset($_POST['passwordL']) != "")) {
        $inN = $_POST['lectureToFeedback'];
        $inP = $_POST['passwordL'];

        //getting valid lecturer names from database
        $sqlLNP = "SELECT lecturerName FROM lecturer WHERE lecturerName='$inN' AND lecturerPassword='$inP'";
        $resultLNP = mysqli_query($conn, $sqlLNP);

        //Show error if there are no data in the table
        if (!$resultLNP) {
            echo(mysqli_error($conn));
        } else {
            //Print out data using while loop
            if (mysqli_fetch_assoc($resultLNP) > 0) {
                echo('<script type="text/javascript">' .
                    'setGotoLecturer("'.$inN.'","'.$inP.'");' .
                    '</script>');
            } else {
                echo('<script type="text/javascript">' .
                    'alert("Invalid password!");' .
                    '</script>');
            }
        }
    }

    if ((isset($_POST['lectureToFeedback']) != "") && (isset($_POST['passwordA']) != "")) {
        $inN = $_POST['lectureToFeedback'];
        $inP = $_POST['passwordA'];

        //getting valid lecturer names from database
        $sqlANP = "SELECT lecturerName FROM lecturer WHERE lecturerName='$inN' AND lecturerPassword='$inP'";
        $resultANP = mysqli_query($conn, $sqlANP);

        //Show error if there are no data in the table
        if (!$resultANP) {
            echo(mysqli_error($conn));
        } else {
            //Print out data using while loop
            if (mysqli_fetch_assoc($resultANP) > 0) {
                echo('<script type="text/javascript">' .
                    'setGotoAdmin("'.$inN.'","'.$inP.'");' .
                    '</script>');
            } else {
                echo('<script type="text/javascript">' .
                    'alert("Invalid password!");' .
                    '</script>');
            }
        }
    }
?>