<?php
    include("../includes/config.php");
    global $conn;
    $sql = "SELECT * FROM User";
    $result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <h1>Welcome</h1>
        <?php
            if (!$result) {
                echo(mysqli_error($conn));
            } else {
                if (mysqli_fetch_assoc($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo("<div><a>Id: " . $row["userId"] . "<br> Username: " . $row["userName"] . "<br><br></a></div>");
                    }
                }
            }
        ?>
    </body>
</html>

