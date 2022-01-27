<?php
// Report all PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("assets/init.php");
$start = new StartCheck();
if ($start->dataBaseCheck() === TRUE) {
    header("Location: page_view.php");
} else {
    $start->writeConfig();
}
