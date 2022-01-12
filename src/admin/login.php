<?php

use Secret\MudCms\persistence\Connection;

if(!isset($_SESSION)) {
    session_start();
    $_SESSION['hit'];
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
            <input class="input-login" type="text" name="email" placeholder="E-post" required></input>
            <input class="input-login" type="password" name="password" placeholder="*********" required></input>
            <input class="input-login" type="submit" name="confirmed" value="Logg inn"></input>
        </form>
        <?php
        $conn = (new Connection)->getConnection();
            if(!empty($_POST['email']) && !empty($_POST['password'])){
                $password = $_POST['password'];
                $check = $conn->prepare('SELECT * FROM users WHERE email = :email');
                $check->execute([':email' => $_POST['email']]);
                $results = $check->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $results['pass']) && $_SESSION['hit'] < 6){
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
        ?>
    </div>
</body>
