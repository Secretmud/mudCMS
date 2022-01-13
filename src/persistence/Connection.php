<?php
namespace Secret\MudCms\persistence;

use PDO;
use PDOException;

class Connection {
    private static $connection;

    public static function getConnection()
    {
        if(!isset(self::$connection)) {
            include('conf/config.php');
            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$database", $username, $pass);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
}
