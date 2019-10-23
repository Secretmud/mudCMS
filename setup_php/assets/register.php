<?php
function register($conn, $user, $pass, $email) {
    if(isset($_POST['submit'])) {
        try {
            $pass = password_hash($pass, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
            $email = $_POST['email'];
            $create = $conn->prepare('INSERT INTO users (username, pass, email) VALUES (:username, :pass, :email)');
            $create->execute([':username' => $user, ':pass' => $pass, ':email' => $email]);
            echo "success";
        } catch (Exception $e) {
            echo "Caught exception: ".$e->getMessage()."\n";
        }
    }
}
