<?php
function db_connect() { 
    static $connection;
    if(!isset($connection)) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $config = parse_ini_file('conf/config.ini');
        $db_host = $config['servername'];
        $db_user = $config['username'];
        $db_pass = $config['password'];
        $db_name = $config['dbname'];
        try {
            $connection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    return $connection;
}
