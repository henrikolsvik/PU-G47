<!-- Made by Navjot on 30.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php 
            global $conn;
            $lectureId = $_POST['lectureId'];
            $lectureName = $_POST['lectureName'];
            $lecturerName = $_POST['lectureToFeedback'];
        ?>
    </head>  
    <body>
        <div align="left" id="menuButton">
            <form id="log_out" action="index.php?page=mainPage" method="POST">
                <button class="bButton" type="submit">LOG OUT</button>
            </form>
            <form id="menu" action="index.php?page=lecturerMain" method="POST">
                <button class="bButton" name="lectureToFeedback" value="<?php echo($lecturerName) ?>" type="submit">MENU</button>
            </form>
        </div>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <div id="info" align="center">
            <h1>Id: <?php echo ($lectureId) ?> Subject: <?php echo ($lectureName) ?> </h1>
            <h2>Lecturer: <?php echo ($lecturerName) ?> </h2>
        </div>

    </body>
</html>
