<?php
    include("includes/config.php");

    //Write this to search for a page: http://localhost/index.php?page=<only page name here>
    if (isset($_GET['page'])) {
        //If we know the page
        if (file_exists("pages/" . $_GET['page'] . ".php")) {
            include("pages/" . $_GET['page'] . ".php");
        }
        //If we know the page but it does not exist
        else {
            include("404.php");
        }
    }
    //If we do not know the page send to main page
    else {
        include("pages/main.php");
    }
?>