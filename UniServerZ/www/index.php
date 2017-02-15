<?php

include("includes/config.php");

//hvis vi går til index uten å vite hvilken page
if ($_GET["page"] == "") {
    include("pages/index.php");
}

//hvis vi vet hvilken page
else if (file_exists("pages/" + $_GET["page"] + ".php")) {
    include($_GET["pages/page" + ".php"]);
}
//hvis vi vet hvilken page men den ikke eksisterer
else {
    include("404.php");
}


?>