<?php
    include("includes/config.php");
    //Main page
    if (!isset($_GET["page"])) {
        include("pages/second.php");
    }
    //If page exist
    else if (file_exists("pages/" + $_GET["page"] + ".php")) {
        include($_GET["pages/page" + ".php"]);
    }
    //If page does not exist
    else {
        include("404.php");
    }
?>