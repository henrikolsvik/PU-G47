<?php
    include("includes/config.php");
    //If we do not know the page
    if ($_GET["page"] == "") {
        include("pages/index.php");
    }
    //If we know the page
    else if (file_exists("pages/" + $_GET["page"] + ".php")) {
        include($_GET["pages/page" + ".php"]);
    }
    //If we know the page but it does not exist
    else {
        include("404.php");
    }
?>