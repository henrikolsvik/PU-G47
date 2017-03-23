<!-- Made by Navjot 23.03.2017 -->

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <?php
            global $conn;
            //getting valid lectureIDs from database
            $lecID = null;
            $lecName = $_POST["lectureToFeedback"]; //Få tilsendt foreleser id fra innloggingssiden;
            $sqlID = "SELECT lecturerId FROM lecturer WHERE lecturerName='$lecName'";
            $resultID = mysqli_query($conn, $sqlID);
            while($rowID = mysqli_fetch_assoc($resultID)){
                $lecID = $rowID["lecturerId"];
            }
        ?>
    </head>
    <body>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <h1>Feedback from previous lectures</h1>
        <h2>Lecturer: <?php echo ($lecName) ?> </h2>
    </body>
</html>