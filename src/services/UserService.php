<?php

namespace Secret\MudCms\services;

use Secret\MudCms\persistence\UserRepo;

class UserService
{
    private UserRepo $user_repo;
    public function __construct() {
        require_once ("../persistence/UserRepo.php");
        $this->user_repo = new UserRepo();
    }

    public function verify_log_in($email, $password) {
        $results = $this->user_repo->get_user_from_email($email);
        if(password_verify($password, $results['pass']) && $_SESSION['hit'] < 600){
            $_SESSION['user'] = $results['username'];
            $_SESSION['rights'] = $results['rights'];
            header('Location: adminPanel.php');
        } else {
            $_SESSION['hit'] += 1;
            echo "Wrong password and/or username";
            insertError($_SESSION['hit'], $_SESSION['REMOTE_ADDR']);
            echo "<br>Failed attempts ".$_SESSION['hit']."<br>";
        }
    }
}