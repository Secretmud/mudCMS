<?php
// Report all PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("assets/init.php");
require_once("persistence/Connection.php");
$start = new StartCheck();
// testing this
if ($start->dataBaseCheck()) {
    header("Location: page_view.php");
} else {
    $start->writeConfig();
}
