<!-- Made by Navjot on 30.03.17 --> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php 
            global $conn;
            $lectureId = $_POST['lectureId'];
            $lectureName = $_POST['lectureName'];
        ?>
    </head>  
    <body>
        <div class="logo">
            <img src="img/ActiFeedBack.svg">
        </div> 
        <div id="info" align="center">
            <h1>Subject: <?php echo ($lectureName) ?> </h1>
        </div>
        <!-- Rating input here -->
    </body>
</html>
