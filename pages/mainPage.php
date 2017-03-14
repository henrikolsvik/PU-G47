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
<script><?php
    //php array to javascript array
    $js_array = json_encode($stack);
    echo("var idArray = ". $js_array . ";\n");
?></script>
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
                <button class="tablinks" onclick="openTab(event, 'Student')" id="defaultOpen"><img src="img/student_icon.png" height="60px" width="50px"/></button>
                <button class="tablinks" onclick="openTab(event, 'Lecturer')"><img src="img/lecturer_icon.png" height="60px" width="60px"/></button>
                <button class="tablinks" onclick="openTab(event, 'Faculty admin')"><img src="img/admin_icon.png" height="60px" width="50px"/></button>
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
                            <!-- Change type to text and uncomement password -->
                            <input class="textInput" id="usernameL" type="number" name="lectureToFeedback" value="" placeholder="Username"/>
                            </br>
                            <!--<input class="textInput" id="passwordL" type="text" name="lectureToFeedback" value="" placeholder="Password"/>-->
                            </br>
                            <input class="aButton" id="lecturerButton" type="submit" onclick="return setGotoLecturer(this)" name="lecturerIS" value="LOG IN"/>  
                        </div>
                    </form>
                </div>
                <div id="Faculty admin" class="tabcontent">
                    <form id="formToValidA" action="" onsubmit="return checkNullAdmin()" method="POST">
                        <div id="formAdmin"> 
                            <input class="textInput" id="usernameA" type="text" name="lectureToFeedback" value="" placeholder="Username"/> 
                            </br>
                            <input class="textInput" id="passwordA" type="text" name="lectureToFeedback" value="" placeholder="Password"/> 
                            </br>
                            <input class="aButton" id="lecturerButton" type="submit" onclick="return setGotoLecturer(this)" name="lecturerIS" value="LOG IN"/>  
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </body>
</html>

<!-- Open student tab as default -->
<script> document.getElementById("defaultOpen").click(); </script>