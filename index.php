<?php
include("addins/head.php");
// Report all PHP errors
error_reporting(-1);
require('assets/connection.php');
include("assets/init.php");
$start = new StartCheck();

if ($start->dataBaseCheck()) {
    header("Location: page_view.php");
} else {
    $start->writeConfig();
}