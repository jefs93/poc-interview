<?php

/*

Made by Javier Fonseca :D

*/

/* Specific file to import */

$file = $_GET['file'];

/*  Testing web server */
echo "POC Created by Javier Fonseca for Lokalise..<br>";

/* Introducing vulnerable code!!! */

if(isset($file))
    {
        include("$file");
    }
else
    {
        include("test.php");
    }

echo "<br><br><br>Made with love <3"
?>