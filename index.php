<?php
// Report all PHP errors
phpinfo();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('assets/connection.php');
include("assets/init.php");
$start = new StartCheck();
// testing this
if ($start->dataBaseCheck()) {
    header("Location: page_view.php");
} else {
    $start->writeConfig();
}
