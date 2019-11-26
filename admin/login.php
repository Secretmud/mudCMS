<?php 
if(!isset($_SESSION)) {
    session_start();
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
            include "../assets/connection.php";
            $conn = dbConnection();
            if(!empty($_POST['email']) && !empty($_POST['password'])){
                //$password = $_POST['password'];
                //$check = $conn->prepare('SELECT * FROM users WHERE email = :email');
                //$check->execute([':email' => $_POST['email']]);
                //$results = $check->fetch(PDO::FETCH_ASSOC);
                //if(password_verify($password, $results['pass'])){
                    //$_SESSION['user'] = $results['username'];
                    //$_SESSION['rights'] = $results['rights'];
                    $_SESSION['user'] = "tete";
                    $_SESSION['rights'] = "admin";
                    echo "<script>console.log( 'Debug Objects: " . $_SESSION['user'] . " ". $_SESSION['rights']. "' );</script>";
                    header('Location: adminPanel.php');
                //} else {
                //    echo "Wrong password and/or username";
                //}
            }
        ?>
    </div>
</body>
