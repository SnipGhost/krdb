<?php

    $page = parseURI();

    if (isset($_SESSION['username'])) {
        if (file_exists("content/$page.php")) {
            include("template/part1.php");
            include("content/$page.php");
            include("template/part2.php");
        } else {
            header("HTTP/1.0 404 Not Found");
            include("engine/error.php");
        }
    } else {
        include("engine/auth.php");
    }

?>