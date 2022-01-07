<?php


function dbConnection() { 
    static $connection;
    if(!isset($connection)) {
        include('conf/config.php');
        try {
            $connection = new PDO("mysql:host=$host;dbname=$database", $username, $pass);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    return $connection;
}