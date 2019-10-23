<form id="register-form" method="post">
    <input name="username" placeholder="username" type="text">
    <input name="email" placeholder="email" type="text">
    <input name="pass1" placeholder="pass" type="password">
    <input name="pass2" placeholder="pass" type="password">
    <input type="submit" placeholder="submit" name="submit" value="register">
</form>
<?php 
    include_once 'connection.php';
    include_once 'register.php';
    if (isset($_POST['submit'])) {
        if ($_POST['pass1'] == $_POST['pass2']) {
            register($conn = db_connect(), $username = $_POST['username'], $pass = $_POST['pass1'], $email = $_POST['email'] );
        } else {
            echo "Password1 and password2 aren't alike";
        }
    }
?>
