<?php

namespace Secret\MudCms\persistence;


use Secret\MudCms\persistence\Connection;
use Exception;
use PDO;

class UserRepo {
    private $conn;

    public function __construct() {
        require_once ("Connection.php");
        $this->conn = (new Connection)->getConnection();
    }

    public function get_user_from_email($email) {
        $check = $this->conn->prepare('SELECT * FROM users WHERE email = :email');
        $check->execute([':email' => $email]);
        return $check->fetch(PDO::FETCH_ASSOC);
    }
}