<!-- Made by Navjot on 16.02.17 --> 

<?php
    //This is the connection file
    include("includes/config.php");

    //Write this to search for a page: http://localhost/index.php?page=<only page name>
    if (isset($_GET['page'])) {
        //If we know the page
        if (file_exists("pages/" . $_GET['page'] . ".php")) {
            include("pages/" . $_GET['page']  . ".php");
        }
        //If we know the page but it does not exist
        else {
            include("404.php");
        }
    }
    //If we do not know the page send to main page
    else {
        include("pages/mainPage.php");
    }
?>