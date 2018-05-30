<?php

    ini_set('display_errors',1);

    session_start();

    require_once("engine/config.php");
    require_once("engine/package.php");

    $mysqli = connectToDB();

    require_once("engine/login.php");
    require_once("engine/new_user.php");
	require_once("engine/router.php");

    $mysqli->close();

?>