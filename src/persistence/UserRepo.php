<?php

namespace Secret\MudCms\persistence;


use Secret\MudCms\persistence\Connection;
use Exception;
use PDO;
require_once ("Connection.php");

class UserRepo {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection)->getConnection();
    }

    public function get_user_from_email($email) {
        $check = $this->conn->prepare('SELECT * FROM users WHERE email = :email');
        $check->execute([':email' => $email]);
        return $check->fetch(PDO::FETCH_ASSOC);
    }

    function newPassword($user_email, $password) {
        $pass_hashed = password_hash($password, PASSWORD_DEFAULT);
        $pass_change = $this->conn->prepare('UPDATE users SET pass = :pass WHERE email = :email');
        $pass_change->execute([':pass' => $pass_hashed, ':email:' => $user_email]);
    }
    function createUser($email, $password, $rights) {
        $pass_hashed = password_hash($password, PASSWORD_DEFAULT);
        $add_user = $this->conn->prepare('INSERT INTO users (email, pass, rights) VALUES (:email, :pass, :rights)');
        $add_user->execute([':email' => $email, ':pass' => $pass_hashed, ':rights' => $rights]);
//        echo 'User has been added to the database';
    }
}