<!-- Made by Navjot on 16.02.17 --> 

<?php
    //Setting up connection
    $host = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "mydb";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>