<?php
    include("addins/head.php");
    // Report all PHP errors
    error_reporting(-1);
    require('assets/connection.php');
    include("assets/init.php");
    $conn = dbConnection();
    $start = new StartCheck($conn, "blog");
    $anyUser = $start->dataBaseCheck();

    echo $anyUser;

    if ($anyUser === true) {
        header("Location: page_view.php");
    } else {
        $start->tableCreate();
    }