<?php


use Secret\MudCms\services\UserService;

if(!isset($_SESSION)) {
    session_start();
//    $_SESSION['hit'];
}
ob_start();
?>
<!DOCTYPE HTML>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Logg inn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="form-parent">
        <form class="form-login" method="POST">
            <input class="input-login" type="text" name="email" placeholder="E-post" required/>
            <input class="input-login" type="password" name="password" placeholder="*********" required/>
            <input class="input-login" type="submit" name="confirmed" value="Logg inn"/>
        </form>
        <?php

        require_once("../services/UserService.php");
            if(!empty($_POST['email']) && !empty($_POST['password'])){
                $password = $_POST['password'];
                $email = $_POST['email'];
                $user_service = new UserService();
                $user_service->verify_log_in($email, $password);
            }
        ?>
    </div>
</body>
