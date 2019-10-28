<?php
function register($conn, $user, $pass, $email) {
    if(isset($_POST['submit'])) {
        try {
            $pass = password_hash($pass, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
            $create = $conn->prepare('INSERT INTO users (username, pass, email, rights) VALUES (:username, :pass, :email, :rights)');
            $create->execute([':username' => $user, ':pass' => $pass, ':email' => $email, ':rights' => "admin"]);
            echo "success";
        } catch (Exception $e) {
            echo "Caught exception: ".$e->getMessage()."\n";
        }
    }
}
